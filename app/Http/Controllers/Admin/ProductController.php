<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSpecification;
use App\Models\Subcategory;
use App\Traits\ImageUploadHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class ProductController extends Controller
{
    use ImageUploadHelper;

    public function index(Request $request)
    {
        $query = Product::with(['category', 'subcategory', 'brand']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        if ($request->filled('brand')) {
            $query->where('brand_id', $request->input('brand'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status') == '1');
        }

        $products = $query->latest()->paginate(15)->withQueryString();
        $categories = Category::orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories', 'brands'));
    }

    public function create()
    {
        $categories = Category::with('subcategories')->orderBy('name')->get();
        $brands = Brand::where('status', true)->orderBy('name')->get();

        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:100',
            'short_description' => 'nullable|string|max:1000',
            'description' => 'nullable|string',
            'features' => 'nullable|string',
            'applications' => 'nullable|string',
            'installation' => 'nullable|string',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'status' => 'boolean',
            'featured' => 'boolean',
            'spec_keys' => 'nullable|array',
            'spec_values' => 'nullable|array',
        ]);

        $slug = Str::slug($validated['name']);
        // Ensure unique slug
        $count = Product::where('slug', 'like', "{$slug}%")->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        $mainImagePath = null;
        if ($request->hasFile('main_image')) {
            $mainImagePath = $this->uploadImage($request->file('main_image'), 'products');
        }

        $product = Product::create([
            'category_id' => $validated['category_id'],
            'subcategory_id' => $validated['subcategory_id'] ?? null,
            'brand_id' => $validated['brand_id'] ?? null,
            'name' => $validated['name'],
            'slug' => $slug,
            'sku' => $validated['sku'],
            'short_description' => $validated['short_description'] ?? null,
            'description' => $validated['description'] ?? null,
            'features' => $validated['features'] ?? null,
            'applications' => $validated['applications'] ?? null,
            'installation' => $validated['installation'] ?? null,
            'main_image' => $mainImagePath,
            'status' => $request->boolean('status', true),
            'featured' => $request->boolean('featured', false),
        ]);

        // Secondary images
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $idx => $file) {
                $path = $this->uploadImage($file, 'products');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_primary' => false,
                    'sort_order' => $idx + 1,
                ]);
            }
        }

        // Specifications
        if (!empty($validated['spec_keys']) && !empty($validated['spec_values'])) {
            foreach ($validated['spec_keys'] as $index => $key) {
                if (!empty($key) && isset($validated['spec_values'][$index]) && !empty($validated['spec_values'][$index])) {
                    ProductSpecification::create([
                        'product_id' => $product->id,
                        'spec_key' => trim($key),
                        'spec_value' => trim($validated['spec_values'][$index]),
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }

    public function show(Product $product)
    {
        return redirect()->route('admin.products.edit', $product);
    }

    public function edit(Product $product)
    {
        $categories = Category::with('subcategories')->orderBy('name')->get();
        $brands = Brand::where('status', true)->orderBy('name')->get();
        $subcategories = Subcategory::where('category_id', $product->category_id)->orderBy('name')->get();
        $product->load(['images', 'specifications']);

        return view('admin.products.edit', compact('product', 'categories', 'brands', 'subcategories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:100',
            'short_description' => 'nullable|string|max:1000',
            'description' => 'nullable|string',
            'features' => 'nullable|string',
            'applications' => 'nullable|string',
            'installation' => 'nullable|string',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'spec_keys' => 'nullable|array',
            'spec_values' => 'nullable|array',
        ]);

        $data = [
            'category_id' => $validated['category_id'],
            'subcategory_id' => $validated['subcategory_id'] ?? null,
            'brand_id' => $validated['brand_id'] ?? null,
            'name' => $validated['name'],
            'sku' => $validated['sku'],
            'short_description' => $validated['short_description'] ?? null,
            'description' => $validated['description'] ?? null,
            'features' => $validated['features'] ?? null,
            'applications' => $validated['applications'] ?? null,
            'installation' => $validated['installation'] ?? null,
            'status' => $request->boolean('status'),
            'featured' => $request->boolean('featured'),
        ];

        if ($request->hasFile('main_image')) {
            $oldMain = $product->main_image;
            $this->deleteUploadedImage($oldMain);
            $data['main_image'] = $this->uploadImage($request->file('main_image'), 'products');

            if ($oldMain) {
                $product->images()->where('image_path', $oldMain)->delete();
            }
            $product->images()->where('is_primary', true)->delete();
        }

        $product->update($data);

        // Upload additional gallery images
        if ($request->hasFile('gallery_images')) {
            $currentOrder = $product->images()->max('sort_order') ?? 0;
            foreach ($request->file('gallery_images') as $file) {
                $currentOrder++;
                $path = $this->uploadImage($file, 'products');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_primary' => false,
                    'sort_order' => $currentOrder,
                ]);
            }
        }

        // Re-sync specifications
        if (isset($validated['spec_keys'])) {
            $product->specifications()->delete();
            foreach ($validated['spec_keys'] as $index => $key) {
                if (!empty($key) && isset($validated['spec_values'][$index]) && !empty($validated['spec_values'][$index])) {
                    ProductSpecification::create([
                        'product_id' => $product->id,
                        'spec_key' => trim($key),
                        'spec_value' => trim($validated['spec_values'][$index]),
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        $this->deleteUploadedImage($product->main_image);

        foreach ($product->images as $img) {
            $this->deleteUploadedImage($img->image_path);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }

    public function deleteImage(ProductImage $image)
    {
        $this->deleteUploadedImage($image->image_path);
        $image->delete();

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Image removed.']);
        }

        return back()->with('success', 'Image removed.');
    }

    public function toggleStatus(Product $product)
    {
        $product->update(['status' => !$product->status]);
        return back()->with('success', 'Product status toggled.');
    }

    public function toggleFeatured(Product $product)
    {
        $product->update(['featured' => !$product->featured]);
        return back()->with('success', 'Featured flag updated.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!empty($ids)) {
            $products = Product::with(['images'])->whereIn('id', $ids)->get();
            foreach ($products as $product) {
                $this->deleteUploadedImage($product->main_image);
                foreach ($product->images as $img) {
                    $this->deleteUploadedImage($img->image_path);
                    $img->delete();
                }
                $product->specifications()->delete();
                $product->delete();
            }
            return back()->with('success', count($ids) . ' products deleted successfully!');
        }
        return back()->with('error', 'No products selected for deletion.');
    }
}
