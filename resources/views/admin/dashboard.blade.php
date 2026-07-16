@extends('layouts.admin')

@section('title', 'GadgetHub - Super Admin Dashboard')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Dashboard Super Admin</h2>
    <p class="text-gray-500 text-sm mt-1">Selamat datang, {{ auth()->user()->name }}</p>
</div>

<!-- Stats -->
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-blue-500">
        <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">User Biasa</p>
        <p class="text-3xl font-bold text-blue-600 mt-1">{{ $stats['total_users'] }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-purple-500">
        <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Merchant</p>
        <p class="text-3xl font-bold text-purple-600 mt-1">{{ $stats['total_merchants'] }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-green-500">
        <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Total Produk</p>
        <p class="text-3xl font-bold text-green-600 mt-1">{{ $stats['total_products'] }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-yellow-500">
        <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Terjual</p>
        <p class="text-3xl font-bold text-yellow-600 mt-1">{{ $stats['total_sold'] }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-pink-500">
        <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Total Chat</p>
        <p class="text-3xl font-bold text-pink-600 mt-1">{{ $stats['total_chats'] }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-teal-500">
        <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Revenue</p>
        <p class="text-lg font-bold text-teal-600 mt-1">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Products -->
    <div class="bg-white rounded-xl shadow-sm">
        <div class="px-6 py-4 border-b flex justify-between items-center">
            <h3 class="font-semibold text-gray-800">Produk Terbaru</h3>
            <a href="{{ route('admin.products') }}" class="text-sm text-blue-600 hover:underline">Lihat semua</a>
        </div>
        <div class="divide-y">
            @forelse($recent_products as $product)
            <div class="flex items-center gap-3 px-6 py-3">
                <img src="{{ $product->photos->first() ? asset($product->photos->first()->photo_url) : 'https://via.placeholder.com/40' }}"
                     class="w-10 h-10 rounded-lg object-cover flex-shrink-0">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-800 truncate">{{ $product->title }}</p>
                    <p class="text-xs text-gray-500">{{ $product->user->name }} &middot; Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                </div>
                <span class="text-xs {{ $product->is_sold ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }} px-2 py-0.5 rounded-full">
                    {{ $product->is_sold ? 'Terjual' : 'Aktif' }}
                </span>
            </div>
            @empty
            <p class="px-6 py-4 text-sm text-gray-400">Belum ada produk.</p>
            @endforelse
        </div>
    </div>

    <!-- Recent Users -->
    <div class="bg-white rounded-xl shadow-sm">
        <div class="px-6 py-4 border-b flex justify-between items-center">
            <h3 class="font-semibold text-gray-800">User Terbaru</h3>
            <a href="{{ route('admin.users') }}" class="text-sm text-blue-600 hover:underline">Lihat semua</a>
        </div>
        <div class="divide-y">
            @forelse($recent_users as $user)
            <div class="flex items-center gap-3 px-6 py-3">
                <img src="{{ $user->profile_photo_url ? asset('storage/' . $user->profile_photo_url) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=6366f1&color=fff' }}"
                     class="w-10 h-10 rounded-full object-cover flex-shrink-0">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-800 truncate">{{ $user->name }}</p>
                    <p class="text-xs text-gray-500">{{ $user->email }}</p>
                </div>
                <span class="text-xs {{ $user->isMerchant() ? 'bg-purple-100 text-purple-600' : 'bg-blue-100 text-blue-600' }} px-2 py-0.5 rounded-full">
                    {{ $user->isMerchant() ? 'Merchant' : 'User' }}
                </span>
            </div>
            @empty
            <p class="px-6 py-4 text-sm text-gray-400">Belum ada user.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
