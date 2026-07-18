<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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

        $rules = [
            'name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ];

        if (! $user->isSuperAdmin()) {
            $rules['address'] = 'nullable|string|max:1000';
        }

        $validated = $request->validate($rules);

        $user->name = $validated['name'];
        $user->phone_number = $validated['phone_number'] ?? null;

        if (! $user->isSuperAdmin()) {
            $user->address = $validated['address'] ?? null;
        }

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo_url) {
                Storage::disk('public')->delete($user->profile_photo_url);
            }

            $path = $request->file('profile_photo')->store('profiles', 'public');
            $user->profile_photo_url = $path;
        }

        $user->save();

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diupdate!');
    }

    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'new_password.required' => 'Password baru wajib diisi.',
            'new_password.min' => 'Password baru minimal 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        if (! Hash::check($request->current_password, $user->password)) {
            return back()
                ->withErrors(['current_password' => 'Password saat ini tidak sesuai.'])
                ->withInput()
                ->with('password_tab', true);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('profile.edit')
            ->with('success_password', 'Password berhasil diubah!');
    }
}
