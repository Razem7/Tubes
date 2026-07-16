@extends('layouts.merchant')

@section('title', 'Dashboard Merchant - GadgetHub')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Dashboard Merchant</h2>
    <p class="text-sm text-gray-500 mt-1">Selamat datang, {{ auth()->user()->name }} 👋</p>
</div>

<!-- Stats -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-purple-500">
        <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Total Produk</p>
        <p class="text-3xl font-bold text-purple-600 mt-1">{{ $stats['total_products'] }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-green-500">
        <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Produk Aktif</p>
        <p class="text-3xl font-bold text-green-600 mt-1">{{ $stats['total_active'] }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-yellow-500">
        <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Terjual</p>
        <p class="text-3xl font-bold text-yellow-600 mt-1">{{ $stats['total_sold'] }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-teal-500">
        <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Total Revenue</p>
        <p class="text-lg font-bold text-teal-600 mt-1">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Produk Terbaru -->
    <div class="bg-white rounded-xl shadow-sm">
        <div class="px-6 py-4 border-b flex justify-between items-center">
            <h3 class="font-semibold text-gray-800">Produk Terbaru</h3>
            <a href="{{ route('merchant.products') }}" class="text-sm text-purple-600 hover:underline">Lihat semua</a>
        </div>
        <div class="divide-y">
            @forelse($recent_products as $product)
            <div class="flex items-center gap-3 px-6 py-3">
                <img src="{{ $product->photos->first() ? asset($product->photos->first()->photo_url) : 'https://via.placeholder.com/40' }}"
                     class="w-10 h-10 rounded-lg object-cover flex-shrink-0">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-800 truncate">{{ $product->title }}</p>
                    <p class="text-xs text-gray-500">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                </div>
                <span class="text-xs {{ $product->is_sold ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }} px-2 py-0.5 rounded-full">
                    {{ $product->is_sold ? 'Terjual' : 'Aktif' }}
                </span>
            </div>
            @empty
            <p class="px-6 py-6 text-sm text-gray-400 text-center">Belum ada produk. <a href="{{ route('merchant.products.create') }}" class="text-purple-600 hover:underline">Tambah sekarang</a></p>
            @endforelse
        </div>
    </div>

    <!-- Penjualan Terbaru -->
    <div class="bg-white rounded-xl shadow-sm">
        <div class="px-6 py-4 border-b flex justify-between items-center">
            <h3 class="font-semibold text-gray-800">Penjualan Terbaru</h3>
            <a href="{{ route('merchant.sales') }}" class="text-sm text-purple-600 hover:underline">Lihat semua</a>
        </div>
        <div class="divide-y">
            @forelse($recent_sales as $sale)
            <div class="flex items-center gap-3 px-6 py-3">
                <img src="{{ $sale->product->photos->first() ? asset($sale->product->photos->first()->photo_url) : 'https://via.placeholder.com/40' }}"
                     class="w-10 h-10 rounded-lg object-cover flex-shrink-0">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-800 truncate">{{ $sale->product->title }}</p>
                    <p class="text-xs text-gray-500">oleh {{ $sale->buyer->name }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm font-semibold text-green-600">Rp {{ number_format($sale->amount, 0, ',', '.') }}</p>
                    <span class="text-xs
                        {{ $sale->status === 'completed' ? 'text-green-600' : ($sale->status === 'cancelled' ? 'text-red-500' : 'text-yellow-600') }}">
                        {{ ucfirst($sale->status) }}
                    </span>
                </div>
            </div>
            @empty
            <p class="px-6 py-6 text-sm text-gray-400 text-center">Belum ada penjualan.</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="mt-6 flex gap-3 flex-wrap">
    <a href="{{ route('merchant.products.create') }}"
       class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Produk
    </a>
    <a href="{{ route('merchant.stock') }}"
       class="inline-flex items-center gap-2 bg-white border border-purple-600 text-purple-600 hover:bg-purple-50 text-sm font-semibold px-5 py-2.5 rounded-lg transition">
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"/></svg>
        Kelola Stok
    </a>
</div>
@endsection
