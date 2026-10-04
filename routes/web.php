<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\BlogCategoryController as AdminBlogCategoryController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\BrandController as AdminBrandController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EnquiryController as AdminEnquiryController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\QuoteRequestController as AdminQuoteRequestController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\SubcategoryController as AdminSubcategoryController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes — Laxmi Hardware Showcase & Catalogue
| Strictly NO e-commerce (No cart, no checkout, no payment, no orders)
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
Route::get('/brand/{slug}', [BrandController::class, 'show'])->name('brands.show');

Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{slug}', [ProjectController::class, 'show'])->name('projects.show');

Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/request-quote', [QuoteController::class, 'index'])->name('quote.index');
Route::post('/request-quote', [QuoteController::class, 'store'])->name('quote.store');

Route::get('/privacy-policy', [HomeController::class, 'privacyPolicy'])->name('privacy');
Route::get('/terms', [HomeController::class, 'terms'])->name('terms');


/*
|--------------------------------------------------------------------------
| Admin Portal Routes — Laxmi Hardware Management
|--------------------------------------------------------------------------
*/

// Admin Guest Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('admin.guest')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    });

    // Admin Authenticated Routes
    Route::middleware('admin.auth')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Products Management
        Route::post('/products/bulk-delete', [AdminProductController::class, 'bulkDelete'])->name('products.bulk-delete');
        Route::post('/products/{product}/toggle-status', [AdminProductController::class, 'toggleStatus'])->name('products.toggle-status');
        Route::post('/products/{product}/toggle-featured', [AdminProductController::class, 'toggleFeatured'])->name('products.toggle-featured');
        Route::delete('/products/image/{image}', [AdminProductController::class, 'deleteImage'])->name('products.image.delete');
        Route::resource('products', AdminProductController::class);

        // Categories & Subcategories
        Route::post('/categories/bulk-delete', [AdminCategoryController::class, 'bulkDelete'])->name('categories.bulk-delete');
        Route::post('/categories/{category}/toggle-status', [AdminCategoryController::class, 'toggleStatus'])->name('categories.toggle-status');
        Route::resource('categories', AdminCategoryController::class);

        Route::post('/subcategories/bulk-delete', [AdminSubcategoryController::class, 'bulkDelete'])->name('subcategories.bulk-delete');
        Route::resource('subcategories', AdminSubcategoryController::class)->except(['create', 'show', 'edit']);

        // Brands
        Route::post('/brands/bulk-delete', [AdminBrandController::class, 'bulkDelete'])->name('brands.bulk-delete');
        Route::post('/brands/{brand}/toggle-status', [AdminBrandController::class, 'toggleStatus'])->name('brands.toggle-status');
        Route::resource('brands', AdminBrandController::class)->except(['show']);

        // Services
        Route::post('/services/bulk-delete', [AdminServiceController::class, 'bulkDelete'])->name('services.bulk-delete');
        Route::resource('services', AdminServiceController::class)->except(['show']);

        // Projects
        Route::post('/projects/bulk-delete', [AdminProjectController::class, 'bulkDelete'])->name('projects.bulk-delete');
        Route::delete('/projects/image/{image}', [AdminProjectController::class, 'deleteImage'])->name('projects.image.delete');
        Route::resource('projects', AdminProjectController::class)->except(['show']);

        // Gallery
        Route::post('/gallery/bulk-delete', [AdminGalleryController::class, 'bulkDelete'])->name('gallery.bulk-delete');
        Route::post('/gallery/{gallery}/toggle-status', [AdminGalleryController::class, 'toggleStatus'])->name('gallery.toggle-status');
        Route::resource('gallery', AdminGalleryController::class)->except(['create', 'show', 'edit']);

        // Blog & Blog Categories
        Route::post('/blog/bulk-delete', [AdminBlogController::class, 'bulkDelete'])->name('blog.bulk-delete');
        Route::resource('blog', AdminBlogController::class)->except(['show']);

        Route::post('/blog-categories/bulk-delete', [AdminBlogCategoryController::class, 'bulkDelete'])->name('blog-categories.bulk-delete');
        Route::resource('blog-categories', AdminBlogCategoryController::class)->except(['create', 'show', 'edit']);

        // Enquiries
        Route::post('/enquiries/bulk-delete', [AdminEnquiryController::class, 'bulkDelete'])->name('enquiries.bulk-delete');
        Route::get('/enquiries', [AdminEnquiryController::class, 'index'])->name('enquiries.index');
        Route::get('/enquiries/{enquiry}', [AdminEnquiryController::class, 'show'])->name('enquiries.show');
        Route::post('/enquiries/{enquiry}/status', [AdminEnquiryController::class, 'updateStatus'])->name('enquiries.update-status');
        Route::delete('/enquiries/{enquiry}', [AdminEnquiryController::class, 'destroy'])->name('enquiries.destroy');

        // Quote Requests
        Route::post('/quote-requests/bulk-delete', [AdminQuoteRequestController::class, 'bulkDelete'])->name('quotes.bulk-delete');
        Route::get('/quote-requests', [AdminQuoteRequestController::class, 'index'])->name('quotes.index');
        Route::get('/quote-requests/{quote}', [AdminQuoteRequestController::class, 'show'])->name('quotes.show');
        Route::post('/quote-requests/{quote}/status', [AdminQuoteRequestController::class, 'updateStatus'])->name('quotes.update-status');
        Route::delete('/quote-requests/{quote}', [AdminQuoteRequestController::class, 'destroy'])->name('quotes.destroy');

        // Testimonials
        Route::post('/testimonials/bulk-delete', [AdminTestimonialController::class, 'bulkDelete'])->name('testimonials.bulk-delete');
        Route::post('/testimonials/{testimonial}/toggle-status', [AdminTestimonialController::class, 'toggleStatus'])->name('testimonials.toggle-status');
        Route::resource('testimonials', AdminTestimonialController::class)->except(['create', 'show', 'edit']);

        // Website Settings
        Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [AdminSettingController::class, 'update'])->name('settings.update');

        // Admin Profile
        Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
    });
});
