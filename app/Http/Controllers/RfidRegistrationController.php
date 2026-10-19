<?php

namespace App\Http\Controllers;

use App\Models\RfidCard;
use Illuminate\Http\Request;

class RfidRegistrationController extends Controller
{
    /**
     * List all registered RFID cards.
     */
    public function index()
    {
        $cards = RfidCard::withCount('scans')
            ->latest()
            ->paginate(15);

        return view('rfid.index', compact('cards'));
    }

    /**
     * Show the registration form.
     */
    public function create()
    {
        return view('rfid.create');
    }

    /**
     * Store a newly registered RFID card.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'uid'         => 'required|string|max:50|unique:rfid_cards,uid',
            'owner_name'  => 'required|string|max:255',
            'owner_email' => 'nullable|email|max:255',
            'owner_phone' => 'nullable|string|max:20',
            'is_active'   => 'nullable|boolean',
        ]);

        // Normalize UID to uppercase so scans always match
        $validated['uid']       = strtoupper(trim($validated['uid']));
        $validated['is_active'] = $request->boolean('is_active', true);

        RfidCard::create($validated);

        return redirect()
            ->route('rfid.index')
            ->with('success', 'RFID card registered successfully.');
    }

    /**
     * Show the edit form for an existing card.
     */
    public function edit(RfidCard $rfidCard)
    {
        return view('rfid.edit', compact('rfidCard'));
    }

    /**
     * Update an existing card.
     */
    public function update(Request $request, RfidCard $rfidCard)
    {
        $validated = $request->validate([
            'uid'         => 'required|string|max:50|unique:rfid_cards,uid,' . $rfidCard->id,
            'owner_name'  => 'required|string|max:255',
            'owner_email' => 'nullable|email|max:255',
            'owner_phone' => 'nullable|string|max:20',
            'is_active'   => 'nullable|boolean',
        ]);

        $validated['uid']       = strtoupper(trim($validated['uid']));
        $validated['is_active'] = $request->boolean('is_active', true);

        $rfidCard->update($validated);

        return redirect()
            ->route('rfid.index')
            ->with('success', 'RFID card updated successfully.');
    }

    /**
     * Delete a card (scans are preserved via nullOnDelete FK).
     */
    public function destroy(RfidCard $rfidCard)
    {
        $rfidCard->delete();

        return redirect()
            ->route('rfid.index')
            ->with('success', 'RFID card deleted successfully.');
    }
}
