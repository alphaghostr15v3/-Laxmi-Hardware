<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Traits\ImageUploadHelper;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    use ImageUploadHelper;

    public function index(Request $request)
    {
        $query = Gallery::query();

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        $items = $query->orderBy('sort_order', 'asc')->latest()->paginate(18)->withQueryString();

        $categories = [
            'Hardware',
            'Kitchens',
            'Wardrobes',
            'Interior Projects',
            'Curtain Installations',
            'Plywood',
            'Accessories',
            'Bathroom & Sanitary',
            'Plumbing Lines'
        ];

        return view('admin.gallery.index', compact('items', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'category'    => 'required|string|max:100',
            'description' => 'nullable|string',
            'images'      => 'required|array|min:1',
            'images.*'    => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
        ]);

        $images = $request->file('images', []);
        if (empty($images)) {
            return back()->withErrors(['images' => 'Please upload at least one image.'])->withInput();
        }

        $sortOrder = Gallery::max('sort_order') ?? 0;

        foreach ($images as $img) {
            $path = $this->uploadImage($img, 'gallery');
            Gallery::create([
                'title'       => $validated['title'],
                'category'    => $validated['category'],
                'description' => $validated['description'] ?? null,
                'image_path'  => $path,
                'sort_order'  => ++$sortOrder,
                'status'      => true,
            ]);
        }

        return back()->with('success', 'Gallery images uploaded successfully!');
    }

    public function edit($gallery)
    {
        if (!($gallery instanceof Gallery)) {
            $gallery = Gallery::findOrFail($gallery);
        }

        $categories = [
            'Hardware', 'Kitchens', 'Wardrobes', 'Interior Projects',
            'Curtain Installations', 'Plywood', 'Accessories',
            'Bathroom & Sanitary', 'Plumbing Lines'
        ];
        return view('admin.gallery.edit', compact('gallery', 'categories'));
    }

    public function update(Request $request, $gallery)
    {
        if (!($gallery instanceof Gallery)) {
            $gallery = Gallery::findOrFail($gallery);
        }

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'category'    => 'required|string|max:100',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'sort_order'  => 'nullable|integer',
        ]);

        $data = [
            'title'       => $validated['title'],
            'category'    => $validated['category'],
            'description' => $validated['description'] ?? null,
            'sort_order'  => $request->filled('sort_order') ? (int) $request->input('sort_order') : ($gallery->sort_order ?? 0),
            'status'      => $request->has('status') ? $request->boolean('status') : false,
        ];

        if ($request->hasFile('image')) {
            $this->deleteUploadedImage($gallery->image_path);
            $data['image_path'] = $this->uploadImage($request->file('image'), 'gallery');
        }

        $gallery->fill($data);
        $gallery->save();

        return back()->with('success', 'Gallery item updated successfully!');
    }

    public function destroy($gallery)
    {
        if (!($gallery instanceof Gallery)) {
            $gallery = Gallery::findOrFail($gallery);
        }

        $this->deleteUploadedImage($gallery->image_path);
        $gallery->delete();

        return back()->with('success', 'Gallery item deleted successfully.');
    }

    public function toggleStatus($gallery)
    {
        if (!($gallery instanceof Gallery)) {
            $gallery = Gallery::findOrFail($gallery);
        }

        $gallery->status = !$gallery->status;
        $gallery->save();

        return back()->with('success', 'Status toggled successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!empty($ids)) {
            $items = Gallery::whereIn('id', $ids)->get();
            foreach ($items as $item) {
                $this->deleteUploadedImage($item->image_path);
                $item->delete();
            }
            return back()->with('success', count($ids) . ' gallery items deleted successfully!');
        }
        return back()->with('error', 'No gallery items selected for deletion.');
    }
}
