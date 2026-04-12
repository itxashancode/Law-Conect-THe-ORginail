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
                    'title' => 'Connect with Elite Legal Minds',
                    'body' => 'Access a curated network of top-tier attorneys ready to serve your needs with discretion and excellence.',
                    'is_active' => true
                ],
                'featured_lawyers' => (object)[
                    'title' => 'Featured Legal Experts',
                    'body' => 'Browse our selection of highly qualified lawyers specializing in various practice areas.',
                    'is_active' => true
                ],
                'call_to_action' => (object)[
                    'title' => 'Ready to Get Started?',
                    'body' => 'Join thousands of clients who have found the perfect legal representation through our platform.',
                    'is_active' => true
                ],
                'footer_about' => (object)[
                    'title' => 'About Law-Conect',
                    'body' => 'We bridge the gap between clients and exceptional legal professionals, ensuring quality legal services are accessible to all.',
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
        $lawyerQuery = Lawyer::where('status', 'approved');

        if ($request->filled('city')) {
            $lawyerQuery->where('city', 'like', '%' . $request->city . '%');
        }

        if ($request->filled('service')) {
            $lawyerQuery->where('specialization', $request->service);
        }

        $lawyers = $lawyerQuery->get();
        return view('public.search', compact('lawyers'));
    }

    /**
     * Show the full public profile for a single approved lawyer.
     */
    public function lawyerProfile($id)
    {
        $lawyer = Lawyer::where('status', 'approved')->with('availabilitySlots')->findOrFail($id);
        return view('public.lawyer-profile', compact('lawyer'));
    }

    /**
     * Show the Privacy Policy page.
     */
    public function privacy()
    {
        return view('public.policy', [
            'title' => 'Privacy Policy',
            'lastUpdated' => 'October 24, 2024',
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
            'lastUpdated' => 'October 24, 2024',
            'content' => 'By accessing or using LegalCounsel, you agree to be bound by these terms. Our service facilitates connections between clients and legal professionals subject to these guidelines.'
        ]);
    }
}
