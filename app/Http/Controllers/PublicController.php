<?php

namespace App\Http\Controllers;

use App\Models\Lawyer;
use App\Models\HomepageContent;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Display the public homepage with featured lawyers and homepage content.
     */
    public function home()
    {
        $featuredLawyers = Lawyer::where('status', 'approved')->latest()->take(6)->get();
        $content = HomepageContent::all()->keyBy('section');
        return view('public.home', compact('featuredLawyers', 'content'));
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
}
