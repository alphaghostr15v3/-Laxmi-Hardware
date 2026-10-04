<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubcategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Subcategory::with('category');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        $subcategories = $query->latest()->paginate(20)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('admin.subcategories.index', compact('subcategories', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'boolean',
        ]);

        Subcategory::create([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'status' => $request->boolean('status', true),
        ]);

        return back()->with('success', 'Subcategory created successfully!');
    }

    public function update(Request $request, Subcategory $subcategory)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'boolean',
        ]);

        $subcategory->update([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'status' => $request->boolean('status'),
        ]);

        return back()->with('success', 'Subcategory updated successfully!');
    }

    public function destroy(Subcategory $subcategory)
    {
        $subcategory->delete();
        return back()->with('success', 'Subcategory deleted successfully!');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!empty($ids)) {
            Subcategory::whereIn('id', $ids)->delete();
            return back()->with('success', count($ids) . ' subcategories deleted successfully!');
        }
        return back()->with('error', 'No subcategories selected for deletion.');
    }
}
