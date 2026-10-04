<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\ImageUploadHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    use ImageUploadHelper;

    public function edit()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.profile', compact('admin'));
    }

    public function update(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $validated = $request->validate([
            'name'             => 'required|string|max:150',
            'email'            => 'required|email|max:150|unique:admins,email,' . $admin->id,
            'current_password' => 'nullable|required_with:new_password',
            'new_password'     => 'nullable|string|min:6|confirmed',
            'avatar'           => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $admin->name  = $validated['name'];
        $admin->email = $validated['email'];

        if ($request->hasFile('avatar')) {
            $this->deleteUploadedImage($admin->avatar);
            $admin->avatar = $this->uploadImage($request->file('avatar'), 'admins');
        }

        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $admin->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }
            $admin->password = Hash::make($request->new_password);
        }

        $admin->save();

        return back()->with('success', 'Profile updated successfully!');
    }
}
