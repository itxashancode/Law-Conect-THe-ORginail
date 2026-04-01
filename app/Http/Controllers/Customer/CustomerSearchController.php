<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Lawyer;
use Illuminate\Http\Request;

class CustomerSearchController extends Controller
{
    /**
     * Display the lawyer search page.
     */
    public function index(Request $request)
    {
        $query = Lawyer::where('status', 'approved');

        if ($request->has('city') && $request->city) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        if ($request->has('service') && $request->service) {
            $query->where('specialization', $request->service);
        }

        $lawyers = $query->get();

        return view('customer.search', compact('lawyers'));
    }
}
