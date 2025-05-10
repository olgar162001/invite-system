<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TemplateController extends Controller
{
    /**
     * Display a listing of the templates.
     */
    public function index()
    {
        $templates = Template::all();
        return view('admin.templates.index', compact('templates'));
    }

    /**
     * Show the form for creating a new template.
     */
    public function create()
    {
        return view('admin.templates.create');
    }

    /**
     * Store a newly created template in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'preview_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'template_file' => 'required|string',
        ]);

        $imagePath = $request->file('preview_image')->store('templates/previews', 'public');

        Template::create([
            'name' => $request->name,
            'preview_image' => $imagePath,
            'template_file' => $request->template_file,
        ]);

        return redirect()->route('templates.index')->with('success', 'Template created successfully!');
    }

    /**
     * Show the form for editing the specified template.
     */
    public function edit(Template $template)
    {
        return view('admin.templates.edit', compact('template'));
    }

    /**
     * Update the specified template in storage.
     */
    public function update(Request $request, Template $template)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'preview_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'template_file' => 'required|string',
        ]);

        if ($request->hasFile('preview_image')) {
            // Delete old image
            Storage::disk('public')->delete($template->preview_image);
            // Store new image
            $template->preview_image = $request->file('preview_image')->store('templates/previews', 'public');
        }

        $template->name = $request->name;
        $template->template_file = $request->template_file;
        $template->save();

        return redirect()->route('templates.index')->with('success', 'Template updated successfully!');
    }

    /**
     * Remove the specified template from storage.
     */
    public function destroy(Template $template)
    {
        // Delete preview image from storage
        Storage::disk('public')->delete($template->preview_image);

        $template->delete();

        return redirect()->route('templates.index')->with('success', 'Template deleted successfully!');
    }
}
