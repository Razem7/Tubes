@extends('layouts.app')

@section('title', 'Favorit - GadgetHub')

@section('content')
<div>
    <h2 class="text-2xl font-bold mb-6">Produk Favorit Saya</h2>
    
    @if($favorites->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($favorites as $favorite)
        @php $product = $favorite->product; @endphp
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
                <form action="{{ route('favorites.toggle', $product) }}" method="POST" class="mt-2">
                    @csrf
                    <button type="submit" class="w-full bg-red-100 text-red-600 px-4 py-2 rounded-lg hover:bg-red-200">
                        Hapus dari Favorit
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $favorites->links() }}
    </div>
    @else
    <div class="bg-white rounded-lg shadow p-8 text-center">
        <p class="text-gray-600 text-lg mb-4">Belum ada produk favorit.</p>
        <a href="{{ route('products.index') }}" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
            Jelajah Produk
        </a>
    </div>
    @endif
</div>
@endsection
