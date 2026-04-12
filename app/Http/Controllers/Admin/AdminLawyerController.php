<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lawyer;

class AdminLawyerController extends Controller
{
    /**
     * Show all lawyer registrations for admin review.
     */
    public function index(\Illuminate\Http\Request $request)
    {
        $query = Lawyer::with('user')->latest();
        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        $lawyers = $query->get();
        return view('admin.lawyers.index', compact('lawyers'));
    }

    /**
     * Approve a lawyer so they can log in and appear in search results.
     */
    public function approve($id)
    {
        Lawyer::findOrFail($id)->update(['status' => 'approved']);
        return back()->with('success', 'Counsel has been approved and listed.');
    }

    /**
     * Reject a lawyer registration.
     */
    public function reject($id)
    {
        Lawyer::findOrFail($id)->update(['status' => 'rejected']);
        return back()->with('warning', 'Lawyer registration has been rejected.');
    }

    /**
     * Suspend an existing lawyer.
     */
    public function suspend($id)
    {
        Lawyer::findOrFail($id)->update(['status' => 'suspended']);
        return back()->with('warning', 'Lawyer account has been suspended.');
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
