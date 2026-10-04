<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Setting;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::where('status', true)->orderBy('sort_order')->get();
        $settings = Setting::getAllSettings();

        return view('pages.services', compact('services', 'settings'));
    }
}
