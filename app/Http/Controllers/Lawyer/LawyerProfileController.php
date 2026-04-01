<?php

namespace App\Http\Controllers\Lawyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LawyerProfileController extends Controller
{
    /**
     * Show the lawyer's profile edit form.
     */
    public function edit()
    {
        $lawyer = Auth::user()->lawyer;
        return view('lawyer.profile.edit', compact('lawyer'));
    }

    /**
     * Update the lawyer's profile information.
     */
    public function update(Request $request)
    {
        $lawyer = Auth::user()->lawyer;

        $request->validate([
            'full_name' => 'required|string|max:255',
            'bar_license' => 'required|string|max:255|unique:lawyers,bar_license,' . $lawyer->id,
            'specialization' => 'required|in:Criminal,Divorce,Affidavit,Civil',
            'city' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'bio' => 'nullable|string',
            'experience_years' => 'required|integer|min:0|max:50',
            'consultation_fee' => 'nullable|numeric|min:0',
        ]);

        $lawyer->update($request->all());

        return back()->with('success', 'Profile updated successfully.');
    }
}
