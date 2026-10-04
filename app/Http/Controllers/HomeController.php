<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('status', true)->orderBy('sort_order', 'asc')->get();
        $featuredProducts = Product::with(['category', 'brand'])
            ->where('status', true)
            ->where('featured', true)
            ->latest()
            ->take(8)
            ->get();
        
        // If featured products < 8, fill with latest active products
        if ($featuredProducts->count() < 4) {
            $featuredProducts = Product::with(['category', 'brand'])
                ->where('status', true)
                ->latest()
                ->take(8)
                ->get();
        }

        $services = Service::where('status', true)->orderBy('sort_order', 'asc')->take(6)->get();
        $projects = Project::where('status', true)->orderBy('sort_order', 'asc')->take(6)->get();
        $brands = Brand::where('status', true)->where('featured', true)->get();
        $testimonials = Testimonial::where('status', true)->orderBy('sort_order', 'asc')->get();
        $settings = Setting::getAllSettings();

        return view('pages.home', compact(
            'categories',
            'featuredProducts',
            'services',
            'projects',
            'brands',
            'testimonials',
            'settings'
        ));
    }

    public function about()
    {
        $settings = Setting::getAllSettings();
        $brands = Brand::where('status', true)->get();
        $testimonials = Testimonial::where('status', true)->orderBy('sort_order', 'asc')->get();

        return view('pages.about', compact('settings', 'brands', 'testimonials'));
    }

    public function privacyPolicy()
    {
        $settings = Setting::getAllSettings();
        return view('pages.privacy', compact('settings'));
    }

    public function terms()
    {
        $settings = Setting::getAllSettings();
        return view('pages.terms', compact('settings'));
    }
}
