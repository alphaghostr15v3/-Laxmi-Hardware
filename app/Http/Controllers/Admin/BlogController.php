<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\ImageUploadHelper;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    use ImageUploadHelper;

    public function index()
    {
        $posts = BlogPost::with('category')->latest()->paginate(15);
        return view('admin.blog.index', compact('posts'));
    }

    public function create()
    {
        $categories = BlogCategory::orderBy('name')->get();
        return view('admin.blog.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:blog_categories,id',
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:1000',
            'content' => 'required|string',
            'author' => 'nullable|string|max:100',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
            'status' => 'boolean',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg,gif,avif|max:10240',
        ]);

        $imagePath = null;
        if ($request->hasFile('featured_image')) {
            $imagePath = $this->uploadImage($request->file('featured_image'), 'blog');
        }

        BlogPost::create([
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'excerpt' => $validated['excerpt'] ?? null,
            'content' => $validated['content'],
            'author' => $validated['author'] ?? 'Laxmi Hardware Team',
            'seo_title' => $validated['seo_title'] ?? $validated['title'],
            'seo_description' => $validated['seo_description'] ?? $validated['excerpt'],
            'status' => $request->boolean('status', true),
            'published_at' => now(),
            'featured_image' => $imagePath,
        ]);

        return redirect()->route('admin.blog.index')->with('success', 'Blog article published successfully!');
    }

    public function edit(BlogPost $blog)
    {
        $categories = BlogCategory::orderBy('name')->get();
        return view('admin.blog.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, BlogPost $blog)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:blog_categories,id',
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:1000',
            'content' => 'required|string',
            'author' => 'nullable|string|max:100',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
            'status' => 'boolean',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg,gif,avif|max:10240',
        ]);

        $data = [
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'excerpt' => $validated['excerpt'] ?? null,
            'content' => $validated['content'],
            'author' => $validated['author'] ?? 'Laxmi Hardware Team',
            'seo_title' => $validated['seo_title'] ?? $validated['title'],
            'seo_description' => $validated['seo_description'] ?? $validated['excerpt'],
            'status' => $request->boolean('status'),
        ];

        if ($request->boolean('remove_image')) {
            if ($blog->featured_image && !str_starts_with($blog->featured_image, '/images') && Storage::disk('public')->exists($blog->featured_image)) {
                $this->deleteUploadedImage($blog->featured_image);
            }
            $data['featured_image'] = null;
        } elseif ($request->hasFile('featured_image')) {
            if ($blog->featured_image && !str_starts_with($blog->featured_image, '/images') && Storage::disk('public')->exists($blog->featured_image)) {
                $this->deleteUploadedImage($blog->featured_image);
            }
            $data['featured_image'] = $this->uploadImage($request->file('featured_image'), 'blog');
        }

        $blog->update($data);

        return redirect()->route('admin.blog.index')->with('success', 'Blog article updated successfully!');
    }

    public function destroy(BlogPost $blog)
    {
        $this->deleteUploadedImage($blog->featured_image);
        $blog->delete();

        return redirect()->route('admin.blog.index')->with('success', 'Blog post removed.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!empty($ids)) {
            $posts = BlogPost::whereIn('id', $ids)->get();
            foreach ($posts as $post) {
                $this->deleteUploadedImage($post->featured_image);
                $post->delete();
            }
            return back()->with('success', count($ids) . ' blog posts deleted successfully!');
        }
        return back()->with('error', 'No blog posts selected for deletion.');
    }
}
