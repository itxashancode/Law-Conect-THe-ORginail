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

// Controller for when a lawyer wants to sign up to our platform!
class LawyerRegistrationController extends Controller
{
    /**
     * Show the lawyer registration form.
     */
    public function showRegistrationForm(): View
    {
        // Just returning the blade view that has the HTML form for lawyers to sign up
        return view('auth.lawyer.register');
    }

    /**
     * Handle lawyer registration.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(Request $request): RedirectResponse
    {
        // Validating everything from the form so nobody can submit bad data!
        $validated = $request->validate([
            // User fields (for login)
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            
            // Lawyer profile fields (for their public page)
            'full_name' => ['required', 'string', 'max:255'],
            'bar_license' => ['required', 'string', 'max:255'],
            'specialization' => ['required', 'in:' . implode(',', config('legal.specializations'))], // Making sure they pick a valid category we have in config
            'city' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:500'],
            'phone' => ['required', 'string', 'max:20'],
            'bio' => ['nullable', 'string', 'max:2000'],
            'experience_years' => ['required', 'integer', 'min:0', 'max:50'],
            'consultation_fee' => ['required', 'numeric', 'min:0'],
            'photo' => ['nullable', 'image', 'max:2048'], // Max 2MB so they don't upload massive files
        ]);

        // Wrap in transaction for data consistency so if something fails, half the account isn't created!
        DB::beginTransaction();

        try {
            // Step 1: Create the base User account so they can actually log in
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']), // Gotta hash the password for security!
                'phone' => $validated['phone'],
                'city' => $validated['city'],
                'user_type' => 'lawyer', // Tagging them as a lawyer
            ]);

            // Assign lawyer role using Spatie roles 
            $user->assignRole('lawyer');

            // Step 2: Handle photo upload if they attached one
            $photoPath = null;
            if ($request->hasFile('photo')) {
                // Saving the image to the storage folder and getting the path back
                $photoPath = $request->file('photo')->store('lawyer-photos', 'public');
            }

            // Step 3: Create Lawyer profile (pending approval) 
            $lawyer = Lawyer::create([
                'user_id' => $user->id, // Linking it back to the user we just made!
                'full_name' => $validated['full_name'],
                'bar_license' => $validated['bar_license'],
                'specialization' => $validated['specialization'],
                'city' => $validated['city'],
                'address' => $validated['address'] ?? null,
                'phone' => $validated['phone'],
                'bio' => $validated['bio'] ?? null,
                'experience_years' => $validated['experience_years'],
                'consultation_fee' => $validated['consultation_fee'],
                'photo' => $photoPath, // Saving the path we got from the upload
                'status' => 'pending', // Admins must approve them first!!!
            ]);

            // Everything worked! Save it all to the database for real
            DB::commit();

            // Log in the user automatically so they don't have to type their password again
            Auth::login($user);

            // Redirect them to the homepage with a nice little banner
            return redirect()->route('home')
                ->with('success', 'Your lawyer profile has been created! Please wait for admin approval before accessing dashboard features.');

        } catch (\Exception $e) {
            // Uh oh, rollback everything we just inserted in the try block
            DB::rollBack();
            
            // Send them back to the form with the error so they can fix it
            return back()->withErrors(['error' => 'Registration failed: ' . $e->getMessage()])->withInput();
        }
    }
}
