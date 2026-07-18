@extends('layouts.app')

@section('title', 'GadgetHub - Profil')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Profil Saya</h2>
            <a href="{{ route('profile.edit') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                Edit Profil
            </a>
        </div>

        <div class="flex items-center space-x-4 mb-6">
            <img src="{{ $user->profile_photo_url ? asset('storage/' . $user->profile_photo_url) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&size=200' }}" 
                 alt="{{ $user->name }}"
                 class="w-24 h-24 rounded-full object-cover">
            <div>
                <h3 class="text-xl font-semibold">{{ $user->name }}</h3>
                @if($user->phone_verified)
                <p class="text-sm text-green-600">✓ Nomor HP Terverifikasi</p>
                @endif
            </div>
        </div>

        <div class="space-y-4">
            <div>
                <label class="text-gray-600 text-sm">Email</label>
                <p class="text-gray-900">{{ $user->email }}</p>
            </div>

            <div>
                <label class="text-gray-600 text-sm">Nomor HP</label>
                <p class="text-gray-900">{{ $user->phone_number ?? '-' }}</p>
            </div>

            @if(! $user->isSuperAdmin())
            <div>
                <label class="text-gray-600 text-sm">Alamat</label>
                <p class="text-gray-900">{{ $user->address ?? '-' }}</p>
            </div>
            @endif

            <div>
                <label class="text-gray-600 text-sm">Bergabung Sejak</label>
                <p class="text-gray-900">{{ $user->created_at->format('d F Y') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
