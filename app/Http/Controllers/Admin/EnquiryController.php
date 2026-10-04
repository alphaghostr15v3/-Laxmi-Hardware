<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    public function index(Request $request)
    {
        $query = Contact::query();

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        $enquiries = $query->latest()->paginate(15)->withQueryString();

        return view('admin.enquiries.index', compact('enquiries'));
    }

    public function show(Contact $enquiry)
    {
        if ($enquiry->status === 'New') {
            $enquiry->update(['status' => 'Read']);
        }
        return view('admin.enquiries.show', compact('enquiry'));
    }

    public function updateStatus(Request $request, Contact $enquiry)
    {
        $validated = $request->validate([
            'status' => 'required|in:New,Read,Contacted,Closed',
            'admin_notes' => 'nullable|string',
        ]);

        $enquiry->update($validated);

        return back()->with('success', 'Enquiry status updated.');
    }

    public function destroy(Contact $enquiry)
    {
        $enquiry->delete();
        return redirect()->route('admin.enquiries.index')->with('success', 'Enquiry deleted.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!empty($ids)) {
            Contact::whereIn('id', $ids)->delete();
            return back()->with('success', count($ids) . ' enquiries deleted successfully!');
        }
        return back()->with('error', 'No enquiries selected for deletion.');
    }
}
