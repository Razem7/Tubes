@extends('layouts.merchant')

@section('title', 'Produk Saya - Merchant GadgetHub')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Produk Saya</h2>
        <p class="text-sm text-gray-500 mt-1">Kelola semua produk yang kamu jual</p>
    </div>
    <a href="{{ route('merchant.products.create') }}"
       class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Produk
    </a>
</div>

<!-- Filter -->
<div class="bg-white rounded-xl shadow-sm p-4 mb-6">
    <form action="{{ route('merchant.products') }}" method="GET" class="flex flex-wrap gap-2">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Cari produk..."
               class="flex-1 min-w-[200px] px-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
        <select name="status" class="px-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
            <option value="">Semua Status</option>
            <option value="active"  {{ request('status') === 'active'  ? 'selected' : '' }}>Aktif</option>
            <option value="sold"    {{ request('status') === 'sold'    ? 'selected' : '' }}>Terjual</option>
        </select>
        <button type="submit" class="bg-purple-600 text-white px-5 py-2 rounded-lg text-sm hover:bg-purple-700">Cari</button>
        <a href="{{ route('merchant.products') }}" class="bg-gray-200 text-gray-700 px-5 py-2 rounded-lg text-sm hover:bg-gray-300">Reset</a>
    </form>
</div>

<!-- Products Grid -->
@if($products->count())
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 mb-4">
    @foreach($products as $product)
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
        <div class="relative">
            <img src="{{ $product->photos->first() ? asset($product->photos->first()->photo_url) : 'https://via.placeholder.com/300x200?text=No+Image' }}"
                 class="w-full h-44 object-cover">
            <span class="absolute top-2 left-2 text-xs font-semibold px-2 py-0.5 rounded-full
                {{ $product->is_sold ? 'bg-red-500 text-white' : 'bg-green-500 text-white' }}">
                {{ $product->is_sold ? 'Terjual' : 'Aktif' }}
            </span>
        </div>
        <div class="p-4">
            <p class="text-sm font-semibold text-gray-800 truncate">{{ $product->title }}</p>
            <p class="text-sm text-purple-600 font-bold mt-1">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-400 mt-1">Stok: {{ $product->stock ?? '-' }} &middot; {{ $product->category->name ?? '-' }}</p>
            <div class="flex gap-2 mt-3">
                <a href="{{ route('merchant.products.edit', $product) }}"
                   class="flex-1 text-center text-xs bg-purple-50 text-purple-700 border border-purple-200 py-1.5 rounded-lg hover:bg-purple-100 font-medium">
                    Edit
                </a>
                <form action="{{ route('merchant.products.destroy', $product) }}" method="POST"
                      onsubmit="return confirm('Hapus produk ini?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="text-xs bg-red-50 text-red-600 border border-red-200 px-3 py-1.5 rounded-lg hover:bg-red-100 font-medium">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
{{ $products->links() }}
@else
<div class="bg-white rounded-xl shadow-sm p-12 text-center">
    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
    </svg>
    <p class="text-gray-500 mb-4">Belum ada produk.</p>
    <a href="{{ route('merchant.products.create') }}" class="inline-flex items-center gap-2 bg-purple-600 text-white text-sm font-semibold px-5 py-2.5 rounded-lg hover:bg-purple-700">
        + Tambah Produk Pertama
    </a>
</div>
@endif
@endsection
