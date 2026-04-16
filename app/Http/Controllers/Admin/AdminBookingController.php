<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    protected $appointmentService;

    public function __construct(\App\Services\AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }

    /**
     * Display all appointments for admin oversight.
     */
    public function index(Request $request)
    {
        $query = Appointment::with('customer', 'lawyer', 'slot')->latest();
        
        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        
        $appointments = $query->get();
        return view('admin.bookings.index', compact('appointments'));
    }

    /**
     * Cancel an appointment and free up the associated slot.
     */
    public function destroy($id)
    {
        $appointment = Appointment::with('slot')->findOrFail($id);
        
        $this->appointmentService->delete($appointment);

        return back()->with('success', 'Appointment has been successfully cancelled and the slot has been released.');
    }
}
