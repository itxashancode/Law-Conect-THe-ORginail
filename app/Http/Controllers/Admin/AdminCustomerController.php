<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminCustomerController extends Controller
{
    /**
     * List all customers.
     */
    public function index()
    {
        $customers = User::role('customer')->latest()->get();
        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Ban a customer by updating their user status.
     */
    public function ban($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'banned']);
        return back()->with('warning', 'Customer has been banned from the platform.');
    }

    /**
     * Unban/Reactivate a customer.
     */
    public function activate($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'active']);
        return back()->with('success', 'Customer account has been reactivated.');
    }

    /**
     * Remove a customer account permanently.
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'Customer account removed.');
    }
}
