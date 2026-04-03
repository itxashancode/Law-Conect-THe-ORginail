<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AvailabilitySlot;
use Illuminate\Http\Request;

class AdminSlotController extends Controller
{
    /**
     * Display all availability slots across all lawyers.
     */
    public function index()
    {
        $slots = AvailabilitySlot::with(['lawyer.user'])
            ->orderBy('available_date', 'desc')
            ->orderBy('start_time', 'asc')
            ->get();
        return view('admin.slots.index', compact('slots'));
    }

    /**
     * Delete a slot (admin can remove any slot).
     */
    public function destroy($id)
    {
        $slot = AvailabilitySlot::with('lawyer')->findOrFail($id);
        $lawyerName = $slot->lawyer->full_name ?? 'Unknown';

        // Free up the slot if it was booked
        if ($slot->is_booked) {
            $slot->update(['is_booked' => false]);
        }

        $slot->delete();

        return back()->with('success', "Slot for {$lawyerName} on {$slot->available_date} deleted.");
    }
}
