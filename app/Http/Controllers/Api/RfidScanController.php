<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RfidCard;
use App\Models\RfidScan;
use App\Models\Device;
use Illuminate\Http\Request;

class RfidScanController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'uid'       => 'required|string|max:50',
            'device_id' => 'required|string|max:50',
            'token'     => 'required|string',
        ]);

        $card = RfidCard::where('uid', $validated['uid'])->first();
        $status = 'unknown';

        if ($card) {
            $status = $card->is_active ? 'authorized' : 'inactive';
        }

        $scan = RfidScan::create([
            'uid'          => $validated['uid'],
            'rfid_card_id' => $card?->id,
            'device_id'    => $validated['device_id'],
            'status'       => $status,
            'ip_address'   => $request->ip(),
        ]);

        Device::updateOrCreate(
            ['device_id' => $validated['device_id']],
            ['last_seen_at' => now(), 'ip_address' => $request->ip()]
        );

        return response()->json([
            'success' => true,
            'status'  => $status,
            'owner'   => $card?->owner_name,
            'scan_id' => $scan->id,
        ]);
    }

    public function heartbeat(Request $request)
    {
        $request->validate(['device_id' => 'required|string']);

        Device::updateOrCreate(
            ['device_id' => $request->device_id],
            ['last_seen_at' => now(), 'ip_address' => $request->ip()]
        );

        return response()->json(['success' => true, 'time' => now()->toIso8601String()]);
    }
}
