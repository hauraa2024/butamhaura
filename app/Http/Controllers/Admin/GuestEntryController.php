<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GuestEntryActionRequest;
use App\Models\GuestEntry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\View\View;

class GuestEntryController extends Controller
{
    public function index(Request $request): View
    {
        [$sort, $direction] = $this->resolveSorting($request);

        return view('admin.guests.index', [
            'pendingEntries' => GuestEntry::query()
                ->where('status', GuestEntry::STATUS_PENDING)
                ->orderBy($sort, $direction)
                ->get(),
            'approvedEntries' => GuestEntry::query()
                ->where('status', GuestEntry::STATUS_APPROVED)
                ->orderBy($sort, $direction)
                ->get(),
            'rejectedEntries' => GuestEntry::query()
                ->where('status', GuestEntry::STATUS_REJECTED)
                ->orderBy($sort, $direction)
                ->get(),
            'sort' => $sort,
            'direction' => $direction,
        ]);
    }

    public function show(GuestEntry $guestEntry): View
    {
        return view('admin.guests.show', [
            'entry' => $guestEntry,
        ]);
    }

    public function destroy(GuestEntry $guestEntry): RedirectResponse
    {
        $guestEntry->delete();

        return redirect()
            ->route('admin.guests.index')
            ->with('status', 'Data tamu dihapus.');
    }

    public function approve(GuestEntryActionRequest $request, GuestEntry $guestEntry): RedirectResponse
    {
        $notes = $request->validated()['notes'] ?? null;

        $guestEntry->update([
            'status' => GuestEntry::STATUS_APPROVED,
            'notes' => $notes,
            'reviewed_by' => $request->user()?->id,
            'reviewed_at' => now(),
        ]);

        return redirect()
            ->route('admin.guests.index')
            ->with('status', 'Data tamu disetujui.');
    }

    public function reject(GuestEntryActionRequest $request, GuestEntry $guestEntry): RedirectResponse
    {
        $notes = $request->validated()['notes'] ?? null;

        $guestEntry->update([
            'status' => GuestEntry::STATUS_REJECTED,
            'notes' => $notes,
            'reviewed_by' => $request->user()?->id,
            'reviewed_at' => now(),
        ]);

        return redirect()
            ->route('admin.guests.index')
            ->with('status', 'Data tamu ditolak.');
    }

    public function exportApproved(): StreamedResponse
    {
        return $this->exportEntries(
            GuestEntry::STATUS_APPROVED,
            'approved-guest-entries-'.now()->format('Y-m-d_H-i').'.csv'
        );
    }

    public function exportRejected(): StreamedResponse
    {
        return $this->exportEntries(
            GuestEntry::STATUS_REJECTED,
            'rejected-guest-entries-'.now()->format('Y-m-d_H-i').'.csv'
        );
    }

    private function exportEntries(string $status, string $filename): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($status): void {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['Nama', 'Email', 'Telepon', 'Instansi', 'Bertemu dengan', 'Tanggal Kunjungan', 'Keperluan', 'Catatan', 'Status', 'Dibuat']);

            GuestEntry::query()
                ->where('status', $status)
                ->orderByDesc('created_at')
                ->chunk(200, function ($entries) use ($handle): void {
                    foreach ($entries as $entry) {
                        fputcsv($handle, [
                            $entry->name,
                            $entry->email,
                            $entry->phone,
                            $entry->organization,
                            $entry->person_to_meet,
                            optional($entry->visit_date)->format('Y-m-d'),
                            $entry->purpose,
                            $entry->notes,
                            $entry->status,
                            $entry->created_at->toDateTimeString(),
                        ]);
                    }
                });

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * @return array{0:string,1:string}
     */
    private function resolveSorting(Request $request): array
    {
        $allowedSorts = ['created_at', 'visit_date', 'name'];
        $sort = $request->get('sort');
        $direction = $request->get('direction') === 'asc' ? 'asc' : 'desc';

        if (! in_array($sort, $allowedSorts, true)) {
            $sort = 'created_at';
        }

        return [$sort, $direction];
    }
}
