<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AvailabilitySlot;
use Illuminate\Http\Request;

class AdminSlotController extends Controller
{
    /**
     * Display all availability slots across all lawyers.
     */
    public function index()
    {
        $slots = AvailabilitySlot::with('lawyer')
            ->orderBy('available_date', 'desc')
            ->get();
        return view('admin.slots.index', compact('slots'));
    }
}
