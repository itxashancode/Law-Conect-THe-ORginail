<?php

namespace App\Http\Controllers\Lawyer;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LawyerAppointmentController extends Controller
{
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
            'allAppointments' => $appointments
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

        if ($appointment->status !== 'pending') {
            return back()->with('error', 'Only pending appointments can be confirmed.');
        }

        $appointment->update(['status' => 'confirmed']);

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

        // Update status to cancelled
        $appointment->update(['status' => 'cancelled']);

        // Free up the slot
        if ($appointment->slot) {
            $appointment->slot->update(['is_booked' => false]);
        }

        return back()->with('success', 'Appointment cancelled and slot released.');
    }
}
