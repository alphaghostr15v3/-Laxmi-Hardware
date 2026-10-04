<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Setting;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $settings = Setting::getAllSettings();
        return view('pages.contact', compact('settings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'phone' => 'required|string|max:25',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|max:3000',
        ]);

        Contact::create($validated);

        return redirect()->route('contact.index')->with('success', 'Thank you for reaching out to Laxmi Hardware! Our team will contact you shortly.');
    }
}
