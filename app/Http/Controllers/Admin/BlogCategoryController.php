<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    public function index()
    {
        $categories = BlogCategory::withCount('posts')->orderBy('name')->get();
        return view('admin.blog.categories', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:blog_categories,name',
        ]);

        BlogCategory::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
        ]);

        return back()->with('success', 'Blog category created.');
    }

    public function update(Request $request, BlogCategory $blogCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:blog_categories,name,' . $blogCategory->id,
        ]);

        $blogCategory->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
        ]);

        return back()->with('success', 'Blog category updated.');
    }

    public function destroy(BlogCategory $blogCategory)
    {
        if ($blogCategory->posts()->count() > 0) {
            return back()->with('error', 'Cannot delete category that contains articles.');
        }

        $blogCategory->delete();
        return back()->with('success', 'Category deleted.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!empty($ids)) {
            $categories = BlogCategory::withCount('posts')->whereIn('id', $ids)->get();
            $deleted = 0;
            foreach ($categories as $cat) {
                if ($cat->posts_count === 0) {
                    $cat->delete();
                    $deleted++;
                }
            }
            if ($deleted > 0) {
                return back()->with('success', $deleted . ' blog categories deleted successfully!');
            }
            return back()->with('error', 'Selected categories contain articles and cannot be deleted.');
        }
        return back()->with('error', 'No blog categories selected for deletion.');
    }
}
