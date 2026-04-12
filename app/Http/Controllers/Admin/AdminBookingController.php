<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    /**
     * Display all appointments for admin oversight.
     */
    public function index()
    {
        $appointments = Appointment::with('customer', 'lawyer', 'slot')
            ->latest()
            ->get();
        return view('admin.bookings.index', compact('appointments'));
    }

    /**
     * Cancel an appointment and free up the associated slot.
     */
    public function destroy($id)
    {
        $appointment = Appointment::with('slot')->findOrFail($id);
        
        \Illuminate\Support\Facades\DB::transaction(function () use ($appointment) {
            if ($appointment->slot) {
                $appointment->slot->update(['is_booked' => false]);
            }
            $appointment->delete();
        });

        return back()->with('success', 'Appointment has been successfully cancelled and the slot has been released.');
    }
}
