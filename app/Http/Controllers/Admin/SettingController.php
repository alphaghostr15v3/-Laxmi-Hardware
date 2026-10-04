<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\ImageUploadHelper;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    use ImageUploadHelper;

    public function index()
    {
        $settings = Setting::getAllSettings();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $inputs = $request->except(['_token', 'logo', 'favicon', 'remove_logo', 'remove_favicon']);

        foreach ($inputs as $key => $val) {
            Setting::set($key, $val ?? '');
        }

        // Logo
        if ($request->boolean('remove_logo')) {
            $old = Setting::get('logo');
            $this->deleteUploadedImage($old);
            Setting::set('logo', '');
        } elseif ($request->hasFile('logo')) {
            $old = Setting::get('logo');
            $this->deleteUploadedImage($old);
            $path = $this->uploadImage($request->file('logo'), 'settings');
            Setting::set('logo', $path);
        }

        // Favicon
        if ($request->boolean('remove_favicon')) {
            $old = Setting::get('favicon');
            $this->deleteUploadedImage($old);
            Setting::set('favicon', '');
        } elseif ($request->hasFile('favicon')) {
            $old = Setting::get('favicon');
            $this->deleteUploadedImage($old);
            $path = $this->uploadImage($request->file('favicon'), 'settings');
            Setting::set('favicon', $path);
        }

        return back()->with('success', 'Website settings saved successfully!');
    }
}
