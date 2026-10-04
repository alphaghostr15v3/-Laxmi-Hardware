<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount(['products' => function ($q) {
            $q->where('status', true);
        }])
        ->with('subcategories')
        ->where('status', true)
        ->orderBy('sort_order')
        ->get();

        return view('pages.categories.index', compact('categories'));
    }

    public function show($slug)
    {
        $category = Category::with('subcategories')
            ->where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();

        $products = Product::with(['brand', 'subcategory'])
            ->where('category_id', $category->id)
            ->where('status', true)
            ->latest()
            ->paginate(12);

        $otherCategories = Category::where('id', '!=', $category->id)
            ->where('status', true)
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        return view('pages.categories.show', compact('category', 'products', 'otherCategories'));
    }
}
