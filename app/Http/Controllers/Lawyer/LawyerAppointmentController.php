<?php

namespace App\Http\Controllers\Lawyer;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// This controller lets the lawyer manage all their bookings
class LawyerAppointmentController extends Controller
{
    protected $appointmentService;

    // Injecting the AppointmentService here so we can reuse its cool functions
    public function __construct(\App\Services\AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }

    /**
     * Display all appointments for the logged-in lawyer.
     */
    public function index(Request $request)
    {
        // Getting the lawyer profile connected to the currently logged in user
        $lawyer = Auth::user()->lawyer;

        // Fetching all their appointments and also grabbing the customer and time slot data so we don't do extra queries later (N+1 baby!)
        $query = $lawyer->appointments()->with(['customer', 'slot']);

        // Check if there's a filter in the URL like ?status=pending
        if ($request->has('status') && in_array($request->status, ['pending', 'confirmed', 'cancelled', 'completed'])) {
            $query->where('status', $request->status); // Filtering the database query
        }

        // Getting the actual data, newest first
        $appointments = $query->orderBy('created_at', 'desc')->get();

        // I'm splitting them up into separate buckets so it's super easy to loop through them in different tabs in the view!
        $pendingAppointments = $appointments->where('status', 'pending');
        $confirmedAppointments = $appointments->where('status', 'confirmed');
        $completedAppointments = $appointments->where('status', 'completed');
        $cancelledAppointments = $appointments->where('status', 'cancelled');

        // Handing off all these buckets to the blade view
        return view('lawyer.appointments.index', compact(
            'lawyer',
            'pendingAppointments',
            'confirmedAppointments',
            'completedAppointments',
            'cancelledAppointments',
            'appointments'
        ));
    }

    /**
     * Show appointment details.
     */
    public function show($id)
    {
        // Grabbing the logged-in lawyer again
        $lawyer = Auth::user()->lawyer;
        
        // Making sure they can only look at THEIR OWN appointment by using their relation!
        // findOrFail will show a 404 error page automatically if someone tries to hack the ID in the URL
        $appointment = $lawyer->appointments()
            ->with(['customer', 'slot'])
            ->findOrFail($id);

        return view('lawyer.appointments.show', compact('appointment'));
    }

    /**
     * Confirm a pending appointment.
     */
    public function confirm($id)
    {
        $lawyer = Auth::user()->lawyer;
        $appointment = $lawyer->appointments()->findOrFail($id); // Security check!

        // I'm using the service I injected to try and confirm it
        // The service returns false if it's already confirmed or something, so we show an error toast
        if (!$this->appointmentService->confirm($appointment)) {
            return back()->with('error', 'Only pending appointments can be confirmed.');
        }

        // Success message for the user!
        return back()->with('success', 'Appointment confirmed.');
    }

    /**
     * Cancel an appointment (by lawyer).
     * Frees up the slot for others.
     */
    public function cancel($id)
    {
        $lawyer = Auth::user()->lawyer;
        $appointment = $lawyer->appointments()->with('slot')->findOrFail($id);

        // Can't cancel something that's already dead or done!
        if ($appointment->status === 'cancelled' || $appointment->status === 'completed') {
            return back()->with('error', 'This appointment cannot be cancelled.');
        }

        // Calling my handy service to cancel the appointment safely inside a database transaction
        $this->appointmentService->cancel($appointment);

        // Let the user know it worked!
        return back()->with('success', 'Appointment cancelled and slot released.');
    }
}
