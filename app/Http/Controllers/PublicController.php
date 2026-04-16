<?php

namespace App\Http\Controllers;

use App\Models\Lawyer;
use App\Models\HomepageContent;
use App\Models\Appointment;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Display the public homepage with featured lawyers and homepage content.
     */
    public function home()
    {
        $featuredLawyers = Lawyer::where('status', 'approved')->latest()->take(6)->get();

        // Stats for count-up animation
        $stats = [
            'total_lawyers' => Lawyer::where('status', 'approved')->count(),
            'total_appointments' => Appointment::count(),
            'total_cities' => Lawyer::where('status', 'approved')->distinct('city')->count('city'),
            'avg_experience' => round(Lawyer::where('status', 'approved')->avg('experience_years') ?? 0),
        ];

        $content = HomepageContent::all()->keyBy('section');

        // Provide fallback content if database is empty
        if ($content->isEmpty()) {
            $content = collect([
                'hero' => (object)[
                    'title' => 'Excellence|Redefined.',
                    'body' => 'Connecting you with the world\'s most distinguished legal professionals through a seamless, secure, and private digital experience.',
                    'is_active' => true
                ],
                'featured_lawyers' => (object)[
                    'title' => 'Selected|Practice Areas',
                    'body' => 'A curated network of specialists across every major legal discipline, ensuring you receive focused, world-class advice.',
                    'is_active' => true
                ],
                'call_to_action' => (object)[
                    'title' => 'Distinguished Counsel',
                    'body' => 'Our Inner Circle',
                    'is_active' => true
                ],
                'footer_about' => (object)[
                    'title' => 'Secure your|legacy today.',
                    'body' => 'Private consultations starting from distinguished professionals across the nation.',
                    'is_active' => true
                ]
            ]);
        }

        return view('public.home', compact('featuredLawyers', 'content', 'stats'));
    }

    /**
     * Handle the lawyer search with optional city and service filters.
     */
    public function search(Request $request)
    {
        $lawyer_query = Lawyer::where('status', 'approved');

        if ($request->filled('city')) {
            $lawyer_query->where('city', 'like', '%' . $request->city . '%');
        }

        if ($request->filled('service')) {
            $lawyer_query->where('specialization', $request->service);
        }

        $lawyers = $lawyer_query->get();
        return view('public.search', compact('lawyers'));
    }

    /**
     * Show the full public profile for a single approved lawyer.
     */
    public function lawyerProfile($slug)
    {
        $lawyer = Lawyer::where('status', 'approved')
            ->where('slug', $slug)
            ->with('availabilitySlots')
            ->firstOrFail();
            
        return view('public.lawyer-profile', compact('lawyer'));
    }

    /**
     * Show the Privacy Policy page.
     */
    public function privacy()
    {
        return view('public.policy', [
            'title' => 'Privacy Policy',
            'lastUpdated' => config('legal.policy_last_updated'),
            'content' => 'We are committed to protecting your personal data and your privacy. This policy explains how we collect, use, and safeguard the information you provide when using LegalCounsel.'
        ]);
    }

    /**
     * Show the Terms of Service page.
     */
    public function terms()
    {
        return view('public.policy', [
            'title' => 'Terms of Service',
            'lastUpdated' => config('legal.policy_last_updated'),
            'content' => 'By accessing or using LegalCounsel, you agree to be bound by these terms. Our service facilitates connections between clients and legal professionals subject to these guidelines.'
        ]);
    }
}
