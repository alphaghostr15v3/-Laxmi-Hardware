<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->input('category');

        $query = Project::where('status', true);
        if ($category && $category !== 'All') {
            $query->where('category', $category);
        }

        $projects = $query->orderBy('sort_order')->latest()->paginate(9)->withQueryString();

        $categories = [
            'All',
            'Residential',
            'Commercial',
            'Office',
            'Kitchen',
            'Bedroom',
            'Living Room',
            'Wardrobe'
        ];

        return view('pages.projects.index', compact('projects', 'categories', 'category'));
    }

    public function show($slug)
    {
        $project = Project::with('images')->where('slug', $slug)->where('status', true)->firstOrFail();

        $relatedProjects = Project::where('id', '!=', $project->id)
            ->where('status', true)
            ->take(3)
            ->get();

        $featuredProducts = Product::with(['category', 'brand'])
            ->where('status', true)
            ->where('featured', true)
            ->take(4)
            ->get();

        return view('pages.projects.show', compact('project', 'relatedProjects', 'featuredProducts'));
    }
}
