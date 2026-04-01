<?php

namespace App\Http\Controllers\Lawyer;

use App\Http\Controllers\Controller;
use App\Models\AvailabilitySlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LawyerSlotController extends Controller
{
    /**
     * Display all availability slots for the logged-in lawyer.
     */
    public function index()
    {
        $lawyer = Auth::user()->lawyer;
        $slots = $lawyer->availabilitySlots()
            ->orderBy('available_date', 'desc')
            ->orderBy('start_time', 'asc')
            ->get();
        return view('lawyer.slots.index', compact('slots'));
    }

    /**
     * Store a new availability slot.
     */
    public function store(Request $request)
    {
        $lawyer = Auth::user()->lawyer;

        $request->validate([
            'available_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        // Check for overlapping slots
        $overlap = AvailabilitySlot::where('lawyer_id', $lawyer->id)
            ->where('available_date', $request->available_date)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                      ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                      ->orWhere(function ($q) use ($request) {
                          $q->where('start_time', '<=', $request->start_time)
                            ->where('end_time', '>=', $request->end_time);
                      });
            })
            ->exists();

        if ($overlap) {
            return back()->with('error', 'This time slot overlaps with an existing slot.');
        }

        AvailabilitySlot::create([
            'lawyer_id' => $lawyer->id,
            'available_date' => $request->available_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'is_booked' => false,
        ]);

        return back()->with('success', 'Availability slot added.');
    }

    /**
     * Remove the specified availability slot.
     */
    public function destroy($id)
    {
        $lawyer = Auth::user()->lawyer;
        $slot = AvailabilitySlot::where('lawyer_id', $lawyer->id)->findOrFail($id);

        if ($slot->is_booked) {
            return back()->with('error', 'Cannot delete a booked slot.');
        }

        $slot->delete();
        return back()->with('success', 'Slot deleted.');
    }
}
