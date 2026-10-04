<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $selectedCategory = $request->input('category', 'All');

        $query = Gallery::where('status', true);
        if ($selectedCategory && $selectedCategory !== 'All') {
            $query->where('category', $selectedCategory);
        }

        $items = $query->orderBy('sort_order')->latest()->paginate(12)->withQueryString();

        $categories = [
            'All',
            'Hardware',
            'Kitchens',
            'Wardrobes',
            'Interior Projects',
            'Curtain Installations',
            'Plywood',
            'Accessories',
        ];

        return view('pages.gallery', compact('items', 'categories', 'selectedCategory'));
    }
}
