<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Lawyer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class LawyerRegistrationController extends Controller
{
    /**
     * Show the lawyer registration form.
     */
    public function showRegistrationForm(): View
    {
        return view('auth.lawyer.register');
    }

    /**
     * Handle lawyer registration.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            // User fields
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            // Lawyer profile fields
            'full_name' => ['required', 'string', 'max:255'],
            'bar_license' => ['required', 'string', 'max:255'],
            'specialization' => ['required', 'in:Criminal,Divorce,Affidavit,Civil'],
            'city' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:500'],
            'phone' => ['required', 'string', 'max:20'],
            'bio' => ['nullable', 'string', 'max:2000'],
            'experience_years' => ['required', 'integer', 'min:0', 'max:50'],
            'consultation_fee' => ['required', 'numeric', 'min:0'],
            'photo' => ['nullable', 'image', 'max:2048'], // Max 2MB
        ]);

        // Wrap in transaction for data consistency
        DB::beginTransaction();

        try {
            // Create User with lawyer role
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'phone' => $validated['phone'],
                'city' => $validated['city'],
                'user_type' => 'lawyer',
            ]);

            // Assign lawyer role
            $user->assignRole('lawyer');

            // Handle photo upload
            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('lawyer-photos', 'public');
            }

            // Create Lawyer profile (pending approval)
            $lawyer = Lawyer::create([
                'user_id' => $user->id,
                'full_name' => $validated['full_name'],
                'bar_license' => $validated['bar_license'],
                'specialization' => $validated['specialization'],
                'city' => $validated['city'],
                'address' => $validated['address'] ?? null,
                'phone' => $validated['phone'],
                'bio' => $validated['bio'] ?? null,
                'experience_years' => $validated['experience_years'],
                'consultation_fee' => $validated['consultation_fee'],
                'photo' => $photoPath,
                'status' => 'pending',
            ]);

            DB::commit();

            // Log in the user
            Auth::login($user);

            return redirect()->route('home')
                ->with('success', 'Your lawyer profile has been created! Please wait for admin approval before accessing dashboard features.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Registration failed: ' . $e->getMessage()])->withInput();
        }
    }
}
