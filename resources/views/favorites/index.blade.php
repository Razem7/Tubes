@extends('layouts.app')

@section('title', 'GadgetHub - Favorit')

@section('content')
<div class="max-w-screen-xl mx-auto px-4 py-6">

    {{-- Header --}}
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Produk Favorit</h2>
        <p class="text-sm text-gray-500 mt-0.5">
            {{ $favorites->count() > 0 ? $favorites->total() . ' produk tersimpan' : 'Belum ada produk favorit' }}
        </p>
    </div>

    @if($favorites->count() > 0)
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
        @foreach($favorites as $favorite)
        @php
            $product = $favorite->product;
            $photo   = $product->photos->first();
            $imgSrc  = $photo && $photo->photo_url ? asset($photo->photo_url) : null;
            $condMap = [
                'new'      => ['Baru',       'bg-green-500'],
                'like_new' => ['Spt Baru',   'bg-blue-500'],
                'good'     => ['Baik',        'bg-yellow-500'],
                'fair'     => ['Cukup Baik',  'bg-orange-500'],
            ];
        @endphp
        <div class="bg-white rounded-xl border border-gray-200 hover:shadow-md transition-shadow overflow-hidden flex flex-col">

            {{-- Foto --}}
            <a href="{{ route('products.show', $product) }}"
               class="relative block bg-gray-100 flex-shrink-0 overflow-hidden"
               style="height: 180px;">
                @if($imgSrc)
                    <img src="{{ $imgSrc }}"
                         alt="{{ $product->title }}"
                         loading="lazy"
                         class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center text-gray-300">
                        <svg class="w-10 h-10 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-xs">No Image</span>
                    </div>
                @endif

                {{-- Badge kondisi --}}
                @if($product->is_sold)
                    <div class="absolute inset-0 bg-black bg-opacity-45 flex items-center justify-center">
                        <span class="bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full">TERJUAL</span>
                    </div>
                @elseif(isset($condMap[$product->condition]))
                    <span class="absolute top-2 left-2 {{ $condMap[$product->condition][1] }} text-white text-xs font-semibold px-2 py-0.5 rounded-md shadow-sm">
                        {{ $condMap[$product->condition][0] }}
                    </span>
                @endif

                {{-- Tombol hapus favorit (pojok kanan atas) --}}
                <form action="{{ route('favorites.toggle', $product) }}" method="POST"
                      class="absolute top-2 right-2">
                    @csrf
                    <button type="submit"
                            title="Hapus dari favorit"
                            class="w-7 h-7 bg-white bg-opacity-90 hover:bg-red-50 rounded-full flex items-center justify-center shadow transition">
                        <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </form>
            </a>

            {{-- Info --}}
            <div class="p-3 flex flex-col flex-1">
                <a href="{{ route('products.show', $product) }}"
                   class="text-sm font-semibold text-gray-800 hover:text-blue-600 leading-snug line-clamp-2 mb-1 transition">
                    {{ $product->title }}
                </a>
                <p class="text-sm font-bold text-blue-600 mb-1">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </p>
                <p class="text-xs text-gray-400 flex items-center gap-1 truncate mt-auto">
                    <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                    </svg>
                    {{ $product->location }}
                </p>
            </div>

        </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $favorites->links() }}
    </div>

    @else
    <div class="bg-white rounded-xl border border-gray-200 py-16 text-center">
        <svg class="w-14 h-14 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
        </svg>
        <p class="text-gray-600 font-medium">Belum ada produk favorit</p>
        <p class="text-sm text-gray-400 mt-1 mb-5">Tap ikon hati di produk untuk menyimpannya di sini</p>
        <a href="{{ route('products.index') }}"
           class="inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition">
            Jelajahi Produk
        </a>
    </div>
    @endif

</div>
@endsection
