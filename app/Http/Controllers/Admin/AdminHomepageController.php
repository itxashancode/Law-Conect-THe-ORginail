<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomepageContent;
use Illuminate\Http\Request;

class AdminHomepageController extends Controller
{
    /**
     * Display homepage content management interface.
     */
    public function index()
    {
        $contents = HomepageContent::all()->keyBy('section');
        $requiredSections = ['hero', 'featured_lawyers', 'call_to_action', 'footer_about'];
        $missingSections = array_diff($requiredSections, $contents->keys()->toArray());

        return view('admin.homepage.index', compact('contents', 'missingSections'));
    }

    /**
     * Create a new homepage content section.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'section' => 'required|string|unique:homepage_contents,section',
            'title' => 'nullable|string|max:255',
            'body' => 'nullable|string',
            'image_path' => 'nullable|string|max:500',
        ]);

        HomepageContent::create($validated);

        return back()->with('success', 'Homepage section created.');
    }

    /**
     * Update a specific homepage content section.
     */
    public function update(Request $request, $id)
    {
        $content = HomepageContent::findOrFail($id);

        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'body' => 'nullable|string',
            'image_path' => 'nullable|string|max:500',
        ]);

        $content->update($validated);

        return back()->with('success', 'Homepage content updated.');
    }
}
