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
}
