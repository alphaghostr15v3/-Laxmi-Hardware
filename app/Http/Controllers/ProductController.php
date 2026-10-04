<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand', 'subcategory'])->where('status', true);

        // Filters
        $filters = [
            'search' => $request->input('search'),
            'category' => $request->input('category'),
            'subcategory' => $request->input('subcategory'),
            'brand' => $request->input('brand'),
            'application' => $request->input('application'),
        ];

        $query->filter($filters);

        // Sorting
        $sort = $request->input('sort', 'latest');
        switch ($sort) {
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'featured':
                $query->orderBy('featured', 'desc')->latest();
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(9)->withQueryString();

        $categories = Category::with('subcategories')->where('status', true)->orderBy('sort_order')->get();
        $brands = Brand::where('status', true)->orderBy('name')->get();

        // Selected filter objects
        $currentCategory = $filters['category'] ? Category::where('slug', $filters['category'])->first() : null;
        $currentBrand = $filters['brand'] ? Brand::where('slug', $filters['brand'])->first() : null;

        return view('pages.products.index', compact(
            'products',
            'categories',
            'brands',
            'filters',
            'sort',
            'currentCategory',
            'currentBrand'
        ));
    }

    public function show($slug)
    {
        $product = Product::with(['category', 'subcategory', 'brand', 'images', 'specifications'])
            ->where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();

        $relatedProducts = Product::with(['category', 'brand'])
            ->where('status', true)
            ->where('id', '!=', $product->id)
            ->where(function ($q) use ($product) {
                $q->where('category_id', $product->category_id)
                  ->orWhere('brand_id', $product->brand_id);
            })
            ->take(4)
            ->get();

        return view('pages.products.show', compact('product', 'relatedProducts'));
    }
}
