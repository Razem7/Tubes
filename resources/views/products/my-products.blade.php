@extends('layouts.app')

@section('title', 'Produk Saya - GadgetHub')

@section('content')
<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Produk Saya</h2>
        <a href="{{ route('products.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            Pasang Iklan Baru
        </a>
    </div>
    
    @if($products->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($products as $product)
        <div class="bg-white rounded-lg shadow hover:shadow-lg transition">
            <a href="{{ route('products.show', $product) }}">
                <img src="{{ $product->photos->first() ? asset('storage/' . $product->photos->first()->photo_url) : 'https://via.placeholder.com/300x300?text=No+Image' }}" 
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
                @if($product->is_sold)
                <span class="inline-block bg-red-100 text-red-600 text-xs px-2 py-1 rounded mb-2">Terjual</span>
                @endif
                <div class="flex gap-2 mt-2">
                    <a href="{{ route('products.edit', $product) }}" class="flex-1 bg-blue-600 text-white text-center px-4 py-2 rounded-lg hover:bg-blue-700 text-sm">
                        Edit
                    </a>
                    <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 text-sm">
                            Hapus
                        </button>
                    </form>
                </div>
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
        <p class="text-gray-600 text-lg mb-4">Anda belum memiliki produk.</p>
        <a href="{{ route('products.create') }}" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
            Pasang Iklan Pertama
        </a>
    </div>
    @endif
</div>
@endsection
