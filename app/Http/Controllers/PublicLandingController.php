<?php

namespace App\Http\Controllers;

use App\Models\GuestEntry;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicLandingController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): View
    {
        $approvedCount = GuestEntry::query()->where('status', GuestEntry::STATUS_APPROVED)->count();
        $pendingCount = GuestEntry::query()->where('status', GuestEntry::STATUS_PENDING)->count();
        $todayCount = GuestEntry::query()->whereDate('created_at', now()->toDateString())->count();
        $rejectedCount = GuestEntry::query()->where('status', GuestEntry::STATUS_REJECTED)->count();

        $totalDecided = $approvedCount + $rejectedCount;
        $approvalRate = $totalDecided > 0 ? round(($approvedCount / $totalDecided) * 100) : null;

        $period = CarbonPeriod::create(now()->subDays(6)->startOfDay(), now()->startOfDay());
        $countsByDate = GuestEntry::query()
            ->whereDate('created_at', '>=', $period->getStartDate())
            ->selectRaw('DATE(created_at) as date')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('date')
            ->pluck('total', 'date');

        $sparkline = collect();
        foreach ($period as $date) {
            $sparkline->push([
                'label' => $date->isoFormat('D MMM'),
                'value' => (int) ($countsByDate[$date->toDateString()] ?? 0),
            ]);
        }

        return view('public.landing', [
            'stats' => [
                'approved' => $approvedCount,
                'pending' => $pendingCount,
                'today' => $todayCount,
                'approvalRate' => $approvalRate,
            ],
            'sparkline' => $sparkline,
        ]);
    }
}
