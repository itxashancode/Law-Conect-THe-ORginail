<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lawyer;
use App\Models\Appointment;
use App\Models\AvailabilitySlot;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard with key statistics.
     */
    public function index()
    {
        $totalLawyers = Lawyer::count();
        $pendingLawyers = Lawyer::where('status', 'pending')->count();
        $approvedLawyers = Lawyer::where('status', 'approved')->count();
        $totalBookings = Appointment::count();
        $pendingBookings = Appointment::where('status', 'pending')->count();
        $totalSlots = AvailabilitySlot::count();
        $bookedSlots = AvailabilitySlot::where('is_booked', true)->count();

        $recentLawyers = Lawyer::latest()->take(5)->get();
        $recentAppointments = Appointment::with('customer', 'lawyer')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalLawyers',
            'pendingLawyers',
            'approvedLawyers',
            'totalBookings',
            'pendingBookings',
            'totalSlots',
            'bookedSlots',
            'recentLawyers',
            'recentAppointments'
        ));
    }

    /**
     * Approve a lawyer after verification.
     */
    public function approve(Lawyer $lawyer)
    {
        $lawyer->update(['status' => 'approved']);
        return back()->with('success', "Counsel {$lawyer->full_name} has been approved and listed in the network.");
    }

    /**
     * Reject or suspend a lawyer.
     */
    public function reject(Lawyer $lawyer)
    {
        $lawyer->update(['status' => 'rejected']);
        return back()->with('warning', "Counsel {$lawyer->full_name} has been marked as rejected.");
    }
}
