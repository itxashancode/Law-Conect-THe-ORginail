<?php

namespace App\Http\Controllers\Lawyer;

use App\Http\Controllers\Controller;
use App\Models\AvailabilitySlot;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class LawyerDashboardController extends Controller
{
    /**
     * Display the lawyer's dashboard.
     */
    public function index()
    {
        $lawyer = Auth::user()->lawyer;
        $totalSlots = $lawyer->availabilitySlots()->count();
        $bookedSlots = $lawyer->availabilitySlots()->where('is_booked', true)->count();
        $upcomingAppointments = Appointment::where('lawyer_id', $lawyer->id)
            ->where('status', 'confirmed')
            ->with('customer')
            ->get();
        $pendingAppointments = Appointment::where('lawyer_id', $lawyer->id)
            ->where('status', 'pending')
            ->with('customer')
            ->get();

        return view('lawyer.dashboard', compact(
            'lawyer',
            'totalSlots',
            'bookedSlots',
            'upcomingAppointments',
            'pendingAppointments'
        ));
    }
}
