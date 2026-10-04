<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Traits\ImageUploadHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    use ImageUploadHelper;

    public function index()
    {
        $brands = Brand::withCount('products')->orderBy('name')->get();
        return view('admin.brands.index', compact('brands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'website'     => 'nullable|url|max:255',
            'logo'        => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:3072',
            'featured'    => 'boolean',
            'status'      => 'boolean',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $this->uploadImage($request->file('logo'), 'brands');
        }

        Brand::create([
            'name'        => $validated['name'],
            'slug'        => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'website'     => $validated['website'] ?? null,
            'logo'        => $logoPath,
            'featured'    => $request->boolean('featured'),
            'status'      => $request->boolean('status', true),
        ]);

        return back()->with('success', 'Brand created successfully!');
    }

    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'website'     => 'nullable|url|max:255',
            'logo'        => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:3072',
            'featured'    => 'boolean',
            'status'      => 'boolean',
        ]);

        $data = [
            'name'        => $validated['name'],
            'description' => $validated['description'] ?? null,
            'website'     => $validated['website'] ?? null,
            'featured'    => $request->boolean('featured'),
            'status'      => $request->boolean('status'),
        ];

        if ($request->hasFile('logo')) {
            $this->deleteUploadedImage($brand->logo);
            $data['logo'] = $this->uploadImage($request->file('logo'), 'brands');
        }

        $brand->update($data);

        return back()->with('success', 'Brand updated successfully!');
    }

    public function destroy(Brand $brand)
    {
        $this->deleteUploadedImage($brand->logo);
        $brand->delete();

        return back()->with('success', 'Brand deleted successfully!');
    }

    public function toggleStatus(Brand $brand)
    {
        $brand->update(['status' => !$brand->status]);
        return back()->with('success', 'Brand status updated.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!empty($ids)) {
            $brands = Brand::whereIn('id', $ids)->get();
            foreach ($brands as $b) {
                $this->deleteUploadedImage($b->logo);
                $b->delete();
            }
            return back()->with('success', count($ids) . ' brands deleted successfully!');
        }
        return back()->with('error', 'No brands selected for deletion.');
    }
}
