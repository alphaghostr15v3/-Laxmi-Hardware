<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Traits\ImageUploadHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    use ImageUploadHelper;

    public function index()
    {
        $projects = Project::withCount('images')->orderBy('sort_order', 'asc')->latest()->paginate(15);
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        $categories = [
            'Residential', 'Commercial', 'Office', 'Kitchen',
            'Bedroom', 'Living Room', 'Wardrobe', 'Bathroom & Plumbing'
        ];
        return view('admin.projects.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'category'         => 'required|string|max:100',
            'location'         => 'nullable|string|max:150',
            'client_type'      => 'nullable|string|max:150',
            'duration'         => 'nullable|string|max:100',
            'description'      => 'nullable|string',
            'materials'        => 'nullable|string',
            'sort_order'       => 'nullable|integer',
            'status'           => 'boolean',
            'featured_image'   => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
        ]);

        $featuredImagePath = null;
        if ($request->hasFile('featured_image')) {
            $featuredImagePath = $this->uploadImage($request->file('featured_image'), 'projects');
        }

        $project = Project::create([
            'title'          => $validated['title'],
            'slug'           => Str::slug($validated['title']),
            'category'       => $validated['category'],
            'location'       => $validated['location'] ?? null,
            'client_type'    => $validated['client_type'] ?? null,
            'duration'       => $validated['duration'] ?? null,
            'description'    => $validated['description'] ?? null,
            'materials'      => $validated['materials'] ?? null,
            'sort_order'     => $validated['sort_order'] ?? 0,
            'status'         => $request->boolean('status', true),
            'featured_image' => $featuredImagePath,
        ]);

        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $idx => $img) {
                $path = $this->uploadImage($img, 'projects');
                ProjectImage::create([
                    'project_id' => $project->id,
                    'image_path' => $path,
                    'sort_order' => $idx + 1,
                ]);
            }
        }

        return redirect()->route('admin.projects.index')->with('success', 'Project added successfully!');
    }

    public function edit(Project $project)
    {
        $categories = [
            'Residential', 'Commercial', 'Office', 'Kitchen',
            'Bedroom', 'Living Room', 'Wardrobe', 'Bathroom & Plumbing'
        ];
        $project->load('images');

        return view('admin.projects.edit', compact('project', 'categories'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'category'         => 'required|string|max:100',
            'location'         => 'nullable|string|max:150',
            'client_type'      => 'nullable|string|max:150',
            'duration'         => 'nullable|string|max:100',
            'description'      => 'nullable|string',
            'materials'        => 'nullable|string',
            'sort_order'       => 'nullable|integer',
            'status'           => 'boolean',
            'featured_image'   => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
        ]);

        $data = [
            'title'       => $validated['title'],
            'category'    => $validated['category'],
            'location'    => $validated['location'] ?? null,
            'client_type' => $validated['client_type'] ?? null,
            'duration'    => $validated['duration'] ?? null,
            'description' => $validated['description'] ?? null,
            'materials'   => $validated['materials'] ?? null,
            'sort_order'  => $validated['sort_order'] ?? 0,
            'status'      => $request->boolean('status'),
        ];

        if ($request->hasFile('featured_image')) {
            $this->deleteUploadedImage($project->featured_image);
            $data['featured_image'] = $this->uploadImage($request->file('featured_image'), 'projects');
        }

        $project->update($data);

        if ($request->hasFile('gallery_images')) {
            $currentOrder = $project->images()->max('sort_order') ?? 0;
            foreach ($request->file('gallery_images') as $img) {
                $currentOrder++;
                $path = $this->uploadImage($img, 'projects');
                ProjectImage::create([
                    'project_id' => $project->id,
                    'image_path' => $path,
                    'sort_order' => $currentOrder,
                ]);
            }
        }

        return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully!');
    }

    public function destroy(Project $project)
    {
        $this->deleteUploadedImage($project->featured_image);

        foreach ($project->images as $img) {
            $this->deleteUploadedImage($img->image_path);
        }

        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully!');
    }

    public function deleteImage(ProjectImage $image)
    {
        $this->deleteUploadedImage($image->image_path);
        $image->delete();

        return back()->with('success', 'Project image removed.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!empty($ids)) {
            $projects = Project::with('images')->whereIn('id', $ids)->get();
            foreach ($projects as $p) {
                $this->deleteUploadedImage($p->featured_image);
                foreach ($p->images as $img) {
                    $this->deleteUploadedImage($img->image_path);
                    $img->delete();
                }
                $p->delete();
            }
            return back()->with('success', count($ids) . ' projects deleted successfully!');
        }
        return back()->with('error', 'No projects selected for deletion.');
    }
}
