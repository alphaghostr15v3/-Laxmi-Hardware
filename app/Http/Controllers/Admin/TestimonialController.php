<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Traits\ImageUploadHelper;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    use ImageUploadHelper;

    public function index()
    {
        $testimonials = Testimonial::orderBy('sort_order', 'asc')->get();
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100',
            'company'     => 'nullable|string|max:150',
            'designation' => 'nullable|string|max:100',
            'review'      => 'required|string|max:2000',
            'rating'      => 'required|integer|min:1|max:5',
            'sort_order'  => 'nullable|integer',
            'status'      => 'boolean',
            'photo'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $this->uploadImage($request->file('photo'), 'testimonials');
        }

        Testimonial::create([
            'name'        => $validated['name'],
            'company'     => $validated['company'] ?? null,
            'designation' => $validated['designation'] ?? null,
            'review'      => $validated['review'],
            'rating'      => $validated['rating'],
            'sort_order'  => $validated['sort_order'] ?? 0,
            'status'      => $request->boolean('status', true),
            'photo'       => $photoPath,
        ]);

        return back()->with('success', 'Testimonial added.');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100',
            'company'     => 'nullable|string|max:150',
            'designation' => 'nullable|string|max:100',
            'review'      => 'required|string|max:2000',
            'rating'      => 'required|integer|min:1|max:5',
            'sort_order'  => 'nullable|integer',
            'status'      => 'boolean',
            'photo'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = [
            'name'        => $validated['name'],
            'company'     => $validated['company'] ?? null,
            'designation' => $validated['designation'] ?? null,
            'review'      => $validated['review'],
            'rating'      => $validated['rating'],
            'sort_order'  => $validated['sort_order'] ?? 0,
            'status'      => $request->boolean('status'),
        ];

        if ($request->hasFile('photo')) {
            $this->deleteUploadedImage($testimonial->photo);
            $data['photo'] = $this->uploadImage($request->file('photo'), 'testimonials');
        }

        $testimonial->update($data);

        return back()->with('success', 'Testimonial updated.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $this->deleteUploadedImage($testimonial->photo);
        $testimonial->delete();

        return back()->with('success', 'Testimonial deleted.');
    }

    public function toggleStatus(Testimonial $testimonial)
    {
        $testimonial->update(['status' => !$testimonial->status]);
        return back()->with('success', 'Testimonial status toggled.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!empty($ids)) {
            $testimonials = Testimonial::whereIn('id', $ids)->get();
            foreach ($testimonials as $t) {
                $this->deleteUploadedImage($t->photo);
                $t->delete();
            }
            return back()->with('success', count($ids) . ' testimonials deleted successfully!');
        }
        return back()->with('error', 'No testimonials selected for deletion.');
    }
}
