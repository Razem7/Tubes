@extends('layouts.app')

@section('title', 'Jelajah Produk - GadgetHub')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold mb-4">Jelajah HP Bekas</h1>
    
    <!-- Search & Filter Form -->
    <form action="{{ route('products.index') }}" method="GET" class="bg-white rounded-lg shadow p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Cari HP..."
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <input type="text" 
                       name="location" 
                       value="{{ request('location') }}"
                       placeholder="Lokasi..."
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <input type="number" 
                       name="min_price" 
                       value="{{ request('min_price') }}"
                       placeholder="Harga Min"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <input type="number" 
                       name="max_price" 
                       value="{{ request('max_price') }}"
                       placeholder="Harga Max"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
            <div>
                <input type="text" 
                       name="brand" 
                       value="{{ request('brand') }}"
                       placeholder="Brand (Samsung, iPhone, dll)"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <select name="category_id" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select name="condition" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Kondisi</option>
                    <option value="new" {{ request('condition') == 'new' ? 'selected' : '' }}>Baru</option>
                    <option value="like_new" {{ request('condition') == 'like_new' ? 'selected' : '' }}>Seperti Baru</option>
                    <option value="good" {{ request('condition') == 'good' ? 'selected' : '' }}>Baik</option>
                    <option value="fair" {{ request('condition') == 'fair' ? 'selected' : '' }}>Cukup Baik</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Cari
                </button>
                <a href="{{ route('products.index') }}" class="flex-1 bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 text-center">
                    Reset
                </a>
            </div>
        </div>
    </form>
</div>

<!-- Products Grid -->
@if($products->count() > 0)
<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
    @foreach($products as $product)
    <div class="bg-white rounded-lg shadow hover:shadow-lg transition">
        <a href="{{ route('products.show', $product) }}">
            <img src="{{ $product->photos->first() && $product->photos->first()->photo_url ? asset($product->photos->first()->photo_url) : 'https://via.placeholder.com/300x300?text=No+Image' }}" 
                 alt="{{ $product->title }}"
                 class="w-full h-48 object-cover rounded-t-lg">
        </a>
        <div class="p-4">
            <a href="{{ route('products.show', $product) }}" class="block">
                <h3 class="font-semibold text-lg mb-2 hover:text-blue-600">{{ $product->title }}</h3>
            </a>
            <p class="text-2xl font-bold text-blue-600 mb-2">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            <div class="flex items-center text-sm text-gray-600 mb-2">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                </svg>
                {{ $product->location }}
            </div>
            <div class="flex items-center text-sm text-gray-600">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                </svg>
                {{ $product->user->name }}
            </div>
            <div class="mt-2 space-y-2">
                <span class="inline-block bg-gray-200 text-gray-700 text-xs px-2 py-1 rounded">
                    {{ ucfirst(str_replace('_', ' ', $product->condition)) }}
                </span>
                @if($product->category)
                <span class="inline-block bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded">
                    {{ $product->category->name }}
                </span>
                @endif
            </div>

            @auth
            <div class="mt-4">
                <form action="{{ route('favorites.toggle', $product) }}" method="POST">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border text-sm font-medium transition {{ !empty($product->is_favorited) ? 'border-red-500 bg-red-50 text-red-600' : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50' }}">
                        {!! !empty($product->is_favorited) ? '❤️' : '🤍' !!}
                        Favorit
                    </button>
                </form>
            </div>
            @else
            <div class="mt-4">
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 text-sm">
                    🤍 Login untuk favorit
                </a>
            </div>
            @endauth
        </div>
    </div>
    @endforeach
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $products->links() }}
</div>
@else
<div class="bg-white rounded-lg shadow p-8 text-center">
    <p class="text-gray-600 text-lg">Tidak ada produk ditemukan.</p>
</div>
@endif
@endsection
