@extends('layouts.app')

@section('title', 'GadgetHub - Edit Profil')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-bold mb-6">Edit Profil</h2>
        
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Foto Profil Saat Ini</label>
                <img src="{{ $user->profile_photo_url ? asset('storage/' . $user->profile_photo_url) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&size=200' }}" 
                     alt="{{ $user->name }}"
                     class="w-24 h-24 rounded-full object-cover mb-2">
            </div>

            <div class="mb-4">
                <label for="profile_photo" class="block text-gray-700 mb-2">Upload Foto Profil Baru</label>
                <input type="file" 
                       id="profile_photo" 
                       name="profile_photo"
                       accept="image/jpeg,image/png,image/jpg"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG. Maksimal 5MB</p>
                @error('profile_photo')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="name" class="block text-gray-700 mb-2">Nama Lengkap *</label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $user->name) }}"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                       required>
                @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="phone_number" class="block text-gray-700 mb-2">Nomor HP</label>
                <input type="text" 
                       id="phone_number" 
                       name="phone_number" 
                       value="{{ old('phone_number', $user->phone_number) }}"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4 bg-gray-100 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Email: {{ $user->email }}</p>
                <p class="text-xs text-gray-500 mt-1">Email tidak dapat diubah</p>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                    Simpan Perubahan
                </button>
                <a href="{{ route('profile.show') }}" class="flex-1 bg-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-400 text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
