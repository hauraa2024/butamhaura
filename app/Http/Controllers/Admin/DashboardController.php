<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GuestEntry;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): View
    {
        $range = $this->resolveRange($request->string('range')->toString());
        $startDate = $this->rangeStartDate($range);

        $chartRows = GuestEntry::query()
            ->whereDate('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(fn ($row) => [
                'label' => Carbon::parse($row->date)->isoFormat('DD MMM'),
                'value' => (int) $row->total,
            ]);

        $pendingCount = GuestEntry::query()->where('status', GuestEntry::STATUS_PENDING)->count();
        $approvedCount = GuestEntry::query()->where('status', GuestEntry::STATUS_APPROVED)->count();
        $rejectedCount = GuestEntry::query()->where('status', GuestEntry::STATUS_REJECTED)->count();
        $todayScheduledCount = GuestEntry::query()
            ->whereDate('visit_date', now()->toDateString())
            ->count();

        return view('admin.dashboard', [
            'user' => $request->user(),
            'chartRange' => $range,
            'chartLabels' => $chartRows->pluck('label'),
            'chartValues' => $chartRows->pluck('value'),
            'stats' => [
                'pending' => $pendingCount,
                'approved' => $approvedCount,
                'rejected' => $rejectedCount,
                'today' => $todayScheduledCount,
            ],
            'latestEntries' => GuestEntry::query()
                ->latest()
                ->take(5)
                ->get(),
        ]);
    }

    private function resolveRange(?string $range): string
    {
        $allowed = ['day', 'week', 'month'];

        if (in_array($range, $allowed, true)) {
            return $range;
        }

        return 'week';
    }

    private function rangeStartDate(string $range): Carbon
    {
        return match ($range) {
            'day' => now()->startOfDay(),
            'month' => now()->startOfMonth(),
            default => now()->startOfWeek(),
        };
    }
}
