<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::withCount(['products' => function ($q) {
            $q->where('status', true);
        }])
        ->where('status', true)
        ->orderBy('name')
        ->get();

        return view('pages.brands.index', compact('brands'));
    }

    public function show($slug)
    {
        $brand = Brand::where('slug', $slug)->where('status', true)->firstOrFail();

        $products = Product::with(['category', 'subcategory'])
            ->where('brand_id', $brand->id)
            ->where('status', true)
            ->latest()
            ->paginate(12);

        $otherBrands = Brand::where('id', '!=', $brand->id)
            ->where('status', true)
            ->take(6)
            ->get();

        return view('pages.brands.show', compact('brand', 'products', 'otherBrands'));
    }
}
