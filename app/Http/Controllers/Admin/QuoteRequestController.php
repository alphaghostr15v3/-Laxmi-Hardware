<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuoteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QuoteRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = QuoteRequest::query();

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('project_type')) {
            $query->where('project_type', $request->input('project_type'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('requirement', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $quotes = $query->latest()->paginate(15)->withQueryString();

        return view('admin.quotes.index', compact('quotes'));
    }

    public function show(QuoteRequest $quote)
    {
        return view('admin.quotes.show', compact('quote'));
    }

    public function updateStatus(Request $request, QuoteRequest $quote)
    {
        $validated = $request->validate([
            'status' => 'required|in:New,Contacted,Quotation Sent,Converted,Closed',
            'admin_notes' => 'nullable|string',
        ]);

        $quote->update($validated);

        return back()->with('success', 'Quote request updated successfully.');
    }

    public function destroy(QuoteRequest $quote)
    {
        if ($quote->attachment_path && Storage::disk('public')->exists($quote->attachment_path)) {
            Storage::disk('public')->delete($quote->attachment_path);
        }
        $quote->delete();

        return redirect()->route('admin.quotes.index')->with('success', 'Quote request removed.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!empty($ids)) {
            $quotes = QuoteRequest::whereIn('id', $ids)->get();
            foreach ($quotes as $q) {
                if ($q->attachment_path && Storage::disk('public')->exists($q->attachment_path)) {
                    Storage::disk('public')->delete($q->attachment_path);
                }
                $q->delete();
            }
            return back()->with('success', count($ids) . ' quote requests deleted successfully!');
        }
        return back()->with('error', 'No quote requests selected for deletion.');
    }
}
