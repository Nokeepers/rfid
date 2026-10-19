<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\RfidScan;

class DeviceStatusController extends Controller
{
    /**
     * Show all devices with online/offline status.
     */
    public function index()
    {
        $devices = Device::orderByDesc('last_seen_at')
            ->get()
            ->map(function (Device $device) {
                $device->online = $device->last_seen_at
                    && $device->last_seen_at->gt(now()->subMinutes(5));

                $device->scans_today = RfidScan::where('device_id', $device->device_id)
                    ->whereDate('created_at', today())
                    ->count();

                $device->scans_total = RfidScan::where('device_id', $device->device_id)->count();

                return $device;
            });

        return view('devices.index', compact('devices'));
    }

    /**
     * JSON endpoint that the dashboard can poll (AJAX) to refresh status.
     */
    public function ping(Device $device)
    {
        return response()->json([
            'device_id'    => $device->device_id,
            'online'       => $device->last_seen_at
                && $device->last_seen_at->gt(now()->subMinutes(5)),
            'last_seen_at' => $device->last_seen_at,
            'ip_address'   => $device->ip_address,
        ]);
    }
}
