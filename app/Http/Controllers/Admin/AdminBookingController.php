<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

// Admin controller for seeing ALL the bookings across the whole platform!
class AdminBookingController extends Controller
{
    protected $appointmentService;

    // Pulling in the service so we can reuse the delete logic!
    public function __construct(\App\Services\AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }

    /**
     * Display all appointments for admin oversight.
     */
    public function index(Request $request)
    {
        // Getting every single appointment ever, and fetching the relations so we avoid the N+1 problem on the admin dashboard
        $query = Appointment::with('customer', 'lawyer', 'slot')->latest();
        
        // If the admin clicked a filter button, we filter the query
        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        
        // Excecuting the query to get the array of appointments
        $appointments = $query->get();
        return view('admin.bookings.index', compact('appointments'));
    }

    /**
     * Cancel an appointment and free up the associated slot.
     */
    public function destroy($id)
    {
        // Finding the appointment and its slot, failing automatically if the ID doesn't exist anymore
        $appointment = Appointment::with('slot')->findOrFail($id);
        
        // Admins can just totally delete appointments if they want using our service
        $this->appointmentService->delete($appointment);

        // Flash a success message
        return back()->with('success', 'Appointment has been successfully cancelled and the slot has been released.');
    }
}
