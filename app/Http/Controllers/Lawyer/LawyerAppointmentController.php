<?php

namespace App\Http\Controllers\Lawyer;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LawyerAppointmentController extends Controller
{
    protected $appointmentService;

    public function __construct(\App\Services\AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }

    /**
     * Display all appointments for the logged-in lawyer.
     */
    public function index(Request $request)
    {
        $lawyer = Auth::user()->lawyer;

        $query = $lawyer->appointments()->with(['customer', 'slot']);

        // Filter by status if provided
        if ($request->has('status') && in_array($request->status, ['pending', 'confirmed', 'cancelled', 'completed'])) {
            $query->where('status', $request->status);
        }

        $appointments = $query->orderBy('created_at', 'desc')->get();

        // Group by status for easier display
        $pendingAppointments = $appointments->where('status', 'pending');
        $confirmedAppointments = $appointments->where('status', 'confirmed');
        $completedAppointments = $appointments->where('status', 'completed');
        $cancelledAppointments = $appointments->where('status', 'cancelled');

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
        $lawyer = Auth::user()->lawyer;
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
        $appointment = $lawyer->appointments()->findOrFail($id);

        if (!$this->appointmentService->confirm($appointment)) {
            return back()->with('error', 'Only pending appointments can be confirmed.');
        }

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

        if ($appointment->status === 'cancelled' || $appointment->status === 'completed') {
            return back()->with('error', 'This appointment cannot be cancelled.');
        }

        $this->appointmentService->cancel($appointment);

        return back()->with('success', 'Appointment cancelled and slot released.');
    }
}
