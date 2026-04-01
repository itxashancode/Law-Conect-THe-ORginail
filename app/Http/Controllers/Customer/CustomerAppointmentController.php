<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Lawyer;
use App\Models\Appointment;
use App\Models\AvailabilitySlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerAppointmentController extends Controller
{
    /**
     * Show all appointments belonging to the logged-in customer.
     */
    public function index()
    {
        $appointments = Appointment::where('customer_id', Auth::id())
            ->with('lawyer')
            ->latest()
            ->get();
        return view('customer.appointments.index', compact('appointments'));
    }

    /**
     * Show the booking form for a specific lawyer with their available slots.
     */
    public function create($lawyerId)
    {
        $lawyer = Lawyer::where('status', 'approved')->findOrFail($lawyerId);
        $availableSlots = AvailabilitySlot::where('lawyer_id', $lawyerId)
            ->where('is_booked', false)
            ->where('available_date', '>=', today())
            ->get();
        return view('customer.appointments.create', compact('lawyer', 'availableSlots'));
    }

    /**
     * Save a new appointment and mark the selected slot as booked.
     */
    public function store(Request $request)
    {
        $request->validate([
            'lawyer_id' => 'required|exists:lawyers,id',
            'slot_id'   => 'required|exists:availability_slots,id',
            'subject'   => 'required|string|max:255',
        ]);

        $slot = AvailabilitySlot::findOrFail($request->slot_id);

        Appointment::create([
            'customer_id'   => Auth::id(),
            'lawyer_id'     => $request->lawyer_id,
            'slot_id'       => $request->slot_id,
            'subject'       => $request->subject,
            'meeting_place' => $request->meeting_place,
        ]);

        $slot->update(['is_booked' => true]);

        return redirect()->route('customer.appointments.index')->with('success', 'Appointment booked.');
    }

    /**
     * Cancel an appointment and free the slot back to available.
     */
    public function destroy($id)
    {
        $appointment = Appointment::where('customer_id', Auth::id())->findOrFail($id);
        AvailabilitySlot::find($appointment->slot_id)?->update(['is_booked' => false]);
        $appointment->delete();
        return back()->with('success', 'Appointment cancelled.');
    }
}
