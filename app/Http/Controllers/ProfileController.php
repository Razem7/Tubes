<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $user = auth()->user();
        return view('profile.show', compact('user'));
    }

    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $user->name = $validated['name'];
        $user->phone_number = $validated['phone_number'] ?? null;

        if ($request->hasFile('profile_photo')) {
            // Delete old photo
            if ($user->profile_photo_url) {
                Storage::disk('public')->delete($user->profile_photo_url);
            }

            // Upload new photo
            $path = $request->file('profile_photo')->store('profiles', 'public');
            $user->profile_photo_url = $path;
        }

        $user->save();

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diupdate!');
    }
}
