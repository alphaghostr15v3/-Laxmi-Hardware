<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\Project;
use App\Models\QuoteRequest;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_products' => Product::count(),
            'total_categories' => Category::count(),
            'total_brands' => Brand::count(),
            'total_services' => Service::count(),
            'total_projects' => Project::count(),
            'total_blog_posts' => BlogPost::count(),
            'total_gallery' => Gallery::count(),
            'total_testimonials' => Testimonial::count(),
            'new_enquiries' => Contact::where('status', 'New')->count(),
            'total_enquiries' => Contact::count(),
            'new_quotes' => QuoteRequest::where('status', 'New')->count(),
            'total_quotes' => QuoteRequest::count(),
        ];

        $recentQuotes = QuoteRequest::latest()->take(6)->get();
        $recentEnquiries = Contact::latest()->take(6)->get();
        $recentProducts = Product::with(['category', 'brand'])->latest()->take(5)->get();

        $categoryStats = Category::withCount('products')->orderBy('products_count', 'desc')->take(6)->get();

        return view('admin.dashboard', compact('stats', 'recentQuotes', 'recentEnquiries', 'recentProducts', 'categoryStats'));
    }
}
