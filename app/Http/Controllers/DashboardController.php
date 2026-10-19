<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\RfidCard;
use App\Models\RfidScan;

class DashboardController extends Controller
{
    /**
     * Show the dashboard with recent scans and system status.
     */
    public function index()
    {
        // Latest 10 scans with owner relationship eager-loaded
        $recentScans = RfidScan::with('rfidCard')
            ->latest()
            ->limit(10)
            ->get();

        // KPI counters
        $totalCards   = RfidCard::count();
        $activeCards  = RfidCard::where('is_active', true)->count();
        $todayScans   = RfidScan::whereDate('created_at', today())->count();
        $unknownScans = RfidScan::where('status', 'unknown')
            ->whereDate('created_at', today())
            ->count();

        // Device heartbeat status
        $lastDevice   = Device::orderByDesc('last_seen_at')->first();
        $deviceOnline = $lastDevice
            && $lastDevice->last_seen_at
            && $lastDevice->last_seen_at->gt(now()->subMinutes(5));

        // Last 7 days scan trend (used for optional chart)
        $weeklyScans = RfidScan::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('dashboard', compact(
            'recentScans',
            'totalCards',
            'activeCards',
            'todayScans',
            'unknownScans',
            'lastDevice',
            'deviceOnline',
            'weeklyScans'
        ));
    }
}
