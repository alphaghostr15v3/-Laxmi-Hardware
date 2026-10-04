<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\ImageUploadHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    use ImageUploadHelper;

    public function index()
    {
        $categories = Category::withCount(['products', 'allSubcategories'])
            ->orderBy('sort_order', 'asc')
            ->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon'        => 'nullable|string|max:50',
            'sort_order'  => 'nullable|integer',
            'status'      => 'boolean',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:3072',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $this->uploadImage($request->file('image'), 'categories');
        }

        Category::create([
            'name'        => $validated['name'],
            'slug'        => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'icon'        => $validated['icon'] ?? null,
            'sort_order'  => $validated['sort_order'] ?? 0,
            'status'      => $request->boolean('status', true),
            'image'       => $imagePath,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully!');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon'        => 'nullable|string|max:50',
            'sort_order'  => 'nullable|integer',
            'status'      => 'boolean',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:3072',
        ]);

        $data = [
            'name'        => $validated['name'],
            'description' => $validated['description'] ?? null,
            'icon'        => $validated['icon'] ?? null,
            'sort_order'  => $validated['sort_order'] ?? 0,
            'status'      => $request->boolean('status'),
        ];

        if ($request->hasFile('image')) {
            $this->deleteUploadedImage($category->image);
            $data['image'] = $this->uploadImage($request->file('image'), 'categories');
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        $this->deleteUploadedImage($category->image);
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully!');
    }

    public function toggleStatus(Category $category)
    {
        $category->update(['status' => !$category->status]);
        return back()->with('success', 'Category status updated.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!empty($ids)) {
            $categories = Category::whereIn('id', $ids)->get();
            foreach ($categories as $cat) {
                $this->deleteUploadedImage($cat->image);
                $cat->delete();
            }
            return back()->with('success', count($ids) . ' categories deleted successfully!');
        }
        return back()->with('error', 'No categories selected for deletion.');
    }
}
