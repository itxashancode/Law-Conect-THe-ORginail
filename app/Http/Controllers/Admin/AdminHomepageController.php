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
        return view('admin.homepage.index', compact('contents'));
    }

    /**
     * Update a specific homepage content section.
     */
    public function update(Request $request, $id)
    {
        $content = HomepageContent::findOrFail($id);

        $request->validate([
            'title' => 'nullable|string|max:255',
            'body' => 'nullable|string',
        ]);

        $content->update([
            'title' => $request->title,
            'body' => $request->body,
        ]);

        return back()->with('success', 'Homepage content updated.');
    }
}
