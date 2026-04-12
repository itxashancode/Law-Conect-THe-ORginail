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
        $lawyer = Auth::user()->lawyer ?: new \App\Models\Lawyer();
        return view('lawyer.profile.edit', compact('lawyer'));
    }

    /**
     * Update the lawyer's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $lawyer = $user->lawyer;

        $request->validate([
            'full_name' => 'required|string|max:255',
            'bar_license' => 'required|string|max:255|unique:lawyers,bar_license,' . ($lawyer->id ?? 'NULL'),
            'specialization' => 'required|in:Criminal,Divorce,Affidavit,Civil,Other',
            'city' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'bio' => 'nullable|string',
            'experience_years' => 'required|integer|min:0|max:50',
            'consultation_fee' => 'nullable|numeric|min:0',
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        $data = $request->except(['photo']);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($lawyer && $lawyer->photo) {
                \Storage::disk('public')->delete($lawyer->photo);
            }
            $data['photo'] = $request->file('photo')->store('lawyer-photos', 'public');
        }

        if ($lawyer) {
            $lawyer->update($data);
        } else {
            $data['user_id'] = $user->id;
            $data['status'] = 'pending'; // New profiles require approval
            \App\Models\Lawyer::create($data);
        }

        return redirect()->route('lawyer.dashboard')->with('success', 'Profile updated successfully.');
    }
}
