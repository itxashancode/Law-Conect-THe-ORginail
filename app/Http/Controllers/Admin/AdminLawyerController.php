<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lawyer;

class AdminLawyerController extends Controller
{
    /**
     * Show all lawyer registrations for admin review.
     */
    public function index()
    {
        $lawyers = Lawyer::with('user')->latest()->get();
        return view('admin.lawyers.index', compact('lawyers'));
    }

    /**
     * Approve a lawyer so they can log in and appear in search results.
     */
    public function approve($id)
    {
        Lawyer::findOrFail($id)->update(['status' => 'approved']);
        return back()->with('success', 'Lawyer approved.');
    }

    /**
     * Reject a lawyer registration.
     */
    public function reject($id)
    {
        Lawyer::findOrFail($id)->update(['status' => 'rejected']);
        return back()->with('success', 'Lawyer rejected.');
    }

    /**
     * Permanently delete a lawyer profile and their user account.
     */
    public function destroy($id)
    {
        Lawyer::findOrFail($id)->delete();
        return back()->with('success', 'Lawyer removed.');
    }
}
