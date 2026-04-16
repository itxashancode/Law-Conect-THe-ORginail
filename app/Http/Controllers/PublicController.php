<?php

namespace App\Http\Controllers;

use App\Models\Lawyer;
use App\Models\HomepageContent;
use App\Models\Appointment;
use Illuminate\Http\Request;

// This controller handles all the public pages that anyone can see without logging in!
class PublicController extends Controller
{
    /**
     * Display the public homepage with featured lawyers and homepage content.
     */
    public function home()
    {
        // Getting the 6 most recently approved lawyers to show them off on the homepage
        $featuredLawyers = Lawyer::where('status', 'approved')->latest()->take(6)->get();

        // Putting together all the stats for that cool count-up animation on the frontend
        $stats = [
            'total_lawyers' => Lawyer::where('status', 'approved')->count(), // How many approved lawyers we have
            'total_appointments' => Appointment::count(), // Total bookings ever made!
            'total_cities' => Lawyer::where('status', 'approved')->distinct('city')->count('city'), // Number of unique cities we cover
            'avg_experience' => round(Lawyer::where('status', 'approved')->avg('experience_years') ?? 0), // Average years of experience, defaulting to 0 if there's none
        ];

        // Fetching the homepage text content and keying it by the section name so it's easy to use in the blade file
        $content = HomepageContent::all()->keyBy('section');

        // Just in case the database is empty, I'm providing some dummy fallback content so the page doesn't look broken!
        if ($content->isEmpty()) {
            $content = collect([
                'hero' => (object)[
                    'title' => 'Excellence|Redefined.',
                    'body' => 'Connecting you with the world\'s most distinguished legal professionals through a seamless, secure, and private digital experience.',
                    'is_active' => true
                ],
                // Fallback for featured lawyers section heading
                'featured_lawyers' => (object)[
                    'title' => 'Selected|Practice Areas',
                    'body' => 'A curated network of specialists across every major legal discipline, ensuring you receive focused, world-class advice.',
                    'is_active' => true
                ],
                // Fallback for the CTA at the bottom 
                'call_to_action' => (object)[
                    'title' => 'Distinguished Counsel',
                    'body' => 'Our Inner Circle',
                    'is_active' => true
                ],
                // Fallback for the footer about blurb
                'footer_about' => (object)[
                    'title' => 'Secure your|legacy today.',
                    'body' => 'Private consultations starting from distinguished professionals across the nation.',
                    'is_active' => true
                ]
            ]);
        }

        // Sending all the data variables to the public.home view!
        return view('public.home', compact('featuredLawyers', 'content', 'stats'));
    }

    /**
     * Handle the lawyer search with optional city and service filters.
     */
    public function search(Request $request)
    {
        // Starting off a query builder for approved lawyers
        $lawyer_query = Lawyer::where('status', 'approved');

        // If the user typed a city, we look for it using a LIKE query for a loose match
        if ($request->filled('city')) {
            $lawyer_query->where('city', 'like', '%' . $request->city . '%');
        }

        // If they chose a specific service/specialization, we filter exactly for that!
        if ($request->filled('service')) {
            $lawyer_query->where('specialization', $request->service);
        }

        // Finally we get all the matched lawyers from the database
        $lawyers = $lawyer_query->get();
        
        // Passing the search results to the search blade template
        return view('public.search', compact('lawyers'));
    }

    /**
     * Show the full public profile for a single approved lawyer.
     */
    public function lawyerProfile($slug)
    {
        // We find an approved lawyer by their slug, and we grab their availability slots too so we can book them
        // using firstOrFail() so it throws a 404 error automatically if they don't exist!
        $lawyer = Lawyer::where('status', 'approved')
            ->where('slug', $slug)
            ->with('availabilitySlots')
            ->firstOrFail();
            
        // Show the lawyer profile page with the lawyer data
        return view('public.lawyer-profile', compact('lawyer'));
    }

    /**
     * Show the Privacy Policy page.
     */
    public function privacy()
    {
        // Returning the policy view with the privacy policy text
        return view('public.policy', [
            'title' => 'Privacy Policy',
            'lastUpdated' => config('legal.policy_last_updated'), // grabbing this from the config so we can change it in one place
            'content' => 'We are committed to protecting your personal data and your privacy. This policy explains how we collect, use, and safeguard the information you provide when using LegalCounsel.'
        ]);
    }

    /**
     * Show the Terms of Service page.
     */
    public function terms()
    {
        // Returning the policy view but with the terms of service text instead
        return view('public.policy', [
            'title' => 'Terms of Service',
            'lastUpdated' => config('legal.policy_last_updated'), // grabbing the updated date from config again
            'content' => 'By accessing or using LegalCounsel, you agree to be bound by these terms. Our service facilitates connections between clients and legal professionals subject to these guidelines.'
        ]);
    }
}
