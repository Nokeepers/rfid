<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\RfidCard;
use App\Models\ScanRecord;
use Illuminate\Http\Request;

class RfidScanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'uid' => 'required|string',
            'mac_address' => 'required|string',
        ]);

        // Find or create the device
        $device = Device::firstOrCreate(
            ['mac_address' => $request->mac_address],
            ['name' => 'Unknown Device', 'is_online' => true]
        );
        $device->update(['last_seen_at' => now(), 'is_online' => true]);

        // Find the RFID card
        $card = RfidCard::where('uid', $request->uid)->first();

        if (!$card) {
            return response()->json(['message' => 'Unknown card'], 404);
        }

        // Record the scan
        $record = ScanRecord::create([
            'rfid_card_id' => $card->id,
            'device_id' => $device->id,
            'scanned_at' => now(),
        ]);

        return response()->json(['message' => 'Scan recorded', 'record' => $record], 201);
    }
}
