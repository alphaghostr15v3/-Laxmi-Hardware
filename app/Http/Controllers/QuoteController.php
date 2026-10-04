<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\QuoteRequest;
use App\Models\Setting;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('status', true)->orderBy('sort_order')->get();
        $settings = Setting::getAllSettings();
        $selectedProduct = $request->input('product', '');
        $selectedCategory = $request->input('category', '');

        return view('pages.quote', compact('categories', 'settings', 'selectedProduct', 'selectedCategory'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'phone' => 'required|string|max:25',
            'company' => 'nullable|string|max:150',
            'project_type' => 'nullable|string|max:100',
            'product_category' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:150',
            'requirement' => 'nullable|string|max:200',
            'message' => 'nullable|string|max:5000',
            'attachment' => [
                'nullable',
                'file',
                'max:10240',
                function ($attribute, $value, $fail) {
                    if ($value) {
                        $allowed = ['pdf', 'jpg', 'jpeg', 'png', 'webp', 'zip', 'dwg', 'dxf'];
                        $ext = strtolower($value->getClientOriginalExtension());
                        if (!in_array($ext, $allowed)) {
                            $fail('The attachment must be a file of type: ' . implode(', ', $allowed) . ' (max 10MB).');
                        }
                    }
                }
            ],
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('quotes', 'public');
        }

        QuoteRequest::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'company' => $validated['company'] ?? null,
            'project_type' => $validated['project_type'] ?? null,
            'product_category' => $validated['product_category'] ?? null,
            'location' => $validated['location'] ?? null,
            'requirement' => $validated['requirement'] ?? null,
            'message' => $validated['message'] ?? null,
            'attachment_path' => $attachmentPath,
            'status' => 'New',
        ]);

        return redirect()->route('quote.index')->with('success', 'Thank you! Your quote request has been submitted. Our team will contact you within 24 hours.');
    }
}
