<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class CustomerDashboardController extends Controller
{
    /**
     * Display the customer's dashboard.
     */
    public function index()
    {
        $customer = Auth::user();
        $upcomingAppointments = Appointment::where('customer_id', $customer->id)
            ->where('status', 'confirmed')
            ->with('lawyer')
            ->orderBy('created_at', 'desc')
            ->get();
        $pendingAppointments = Appointment::where('customer_id', $customer->id)
            ->where('status', 'pending')
            ->with('lawyer')
            ->orderBy('created_at', 'desc')
            ->get();
        $completedAppointments = Appointment::where('customer_id', $customer->id)
            ->where('status', 'completed')
            ->with('lawyer')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('customer.dashboard', compact(
            'customer',
            'upcomingAppointments',
            'pendingAppointments',
            'completedAppointments'
        ));
    }
}
