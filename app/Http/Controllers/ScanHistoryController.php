<?php

namespace App\Http\Controllers;

use App\Models\RfidScan;
use Illuminate\Http\Request;

class ScanHistoryController extends Controller
{
    /**
     * Display all RFID scan records with filters.
     */
    public function index(Request $request)
    {
        $query = RfidScan::with('rfidCard');

        // Filter: status
        if ($request->filled('status')
            && in_array($request->status, ['authorized', 'unknown', 'inactive'], true)) {
            $query->where('status', $request->status);
        }

        // Filter: UID contains
        if ($request->filled('uid')) {
            $query->where('uid', 'like', '%' . $request->uid . '%');
        }

        // Filter: device
        if ($request->filled('device_id')) {
            $query->where('device_id', $request->device_id);
        }

        // Filter: date range
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        $scans = $query->latest()->paginate(25)->withQueryString();

        // Distinct devices for the filter dropdown
        $devices = RfidScan::select('device_id')
            ->distinct()
            ->orderBy('device_id')
            ->pluck('device_id');

        return view('scans.index', compact('scans', 'devices'));
    }

    /**
     * Show a single scan record.
     */
    public function show(RfidScan $scan)
    {
        $scan->load('rfidCard');

        return view('scans.show', compact('scan'));
    }
}
