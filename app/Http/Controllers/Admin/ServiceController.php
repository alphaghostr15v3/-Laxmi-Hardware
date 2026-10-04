<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Traits\ImageUploadHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    use ImageUploadHelper;

    public function index()
    {
        $services = Service::orderBy('sort_order', 'asc')->get();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'             => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'description'       => 'nullable|string',
            'features'          => 'nullable|string',
            'icon'              => 'nullable|string|max:50',
            'sort_order'        => 'nullable|integer',
            'status'            => 'boolean',
            'image'             => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:4096',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $this->uploadImage($request->file('image'), 'services');
        }

        Service::create([
            'title'             => $validated['title'],
            'slug'              => Str::slug($validated['title']),
            'short_description' => $validated['short_description'] ?? null,
            'description'       => $validated['description'] ?? null,
            'features'          => $validated['features'] ?? null,
            'icon'              => $validated['icon'] ?? null,
            'sort_order'        => $validated['sort_order'] ?? 0,
            'status'            => $request->boolean('status', true),
            'image'             => $imagePath,
        ]);

        return redirect()->route('admin.services.index')->with('success', 'Service created successfully!');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'title'             => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'description'       => 'nullable|string',
            'features'          => 'nullable|string',
            'icon'              => 'nullable|string|max:50',
            'sort_order'        => 'nullable|integer',
            'status'            => 'boolean',
            'image'             => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:4096',
        ]);

        $data = [
            'title'             => $validated['title'],
            'short_description' => $validated['short_description'] ?? null,
            'description'       => $validated['description'] ?? null,
            'features'          => $validated['features'] ?? null,
            'icon'              => $validated['icon'] ?? null,
            'sort_order'        => $validated['sort_order'] ?? 0,
            'status'            => $request->boolean('status'),
        ];

        if ($request->hasFile('image')) {
            $this->deleteUploadedImage($service->image);
            $data['image'] = $this->uploadImage($request->file('image'), 'services');
        }

        $service->update($data);

        return redirect()->route('admin.services.index')->with('success', 'Service updated successfully!');
    }

    public function destroy(Service $service)
    {
        $this->deleteUploadedImage($service->image);
        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Service deleted successfully!');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!empty($ids)) {
            $services = Service::whereIn('id', $ids)->get();
            foreach ($services as $s) {
                $this->deleteUploadedImage($s->image);
                $s->delete();
            }
            return back()->with('success', count($ids) . ' services deleted successfully!');
        }
        return back()->with('error', 'No services selected for deletion.');
    }
}
