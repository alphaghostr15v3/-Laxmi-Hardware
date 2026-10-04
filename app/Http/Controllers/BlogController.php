<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::with('category')->where('status', true);

        if ($request->filled('category')) {
            $catSlug = $request->input('category');
            $query->whereHas('category', function ($q) use ($catSlug) {
                $q->where('slug', $catSlug);
            });
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $posts = $query->latest('published_at')->paginate(6)->withQueryString();
        $categories = BlogCategory::withCount('posts')->get();
        $recentPosts = BlogPost::where('status', true)->latest('published_at')->take(4)->get();

        return view('pages.blog.index', compact('posts', 'categories', 'recentPosts'));
    }

    public function show($slug)
    {
        $post = BlogPost::with('category')
            ->where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();

        $relatedPosts = BlogPost::where('status', true)
            ->where('id', '!=', $post->id)
            ->where('category_id', $post->category_id)
            ->take(3)
            ->get();

        $categories = BlogCategory::withCount('posts')->get();

        return view('pages.blog.show', compact('post', 'relatedPosts', 'categories'));
    }
}
