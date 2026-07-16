@extends('layouts.app')

@section('title', 'GadgetHub - Produk Saya')

@section('content')
<div class="max-w-screen-xl mx-auto px-4 py-6">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Produk Saya</h2>
            <p class="text-sm text-gray-500 mt-0.5">Kelola semua iklan yang kamu pasang</p>
        </div>
        <a href="{{ route('products.create') }}"
           class="flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Pasang Iklan Baru
        </a>
    </div>

    @if($products->count() > 0)
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
        @foreach($products as $product)
        @php
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

            {{-- Foto — fixed height --}}
            <a href="{{ route('products.show', $product) }}" class="relative block bg-gray-100 overflow-hidden flex-shrink-0" style="height: 180px;">
                @if($imgSrc)
                    <img src="{{ $imgSrc }}"
                         alt="{{ $product->title }}"
                         loading="lazy"
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center text-gray-300">
                        <svg class="w-10 h-10 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-xs">No Image</span>
                    </div>
                @endif

                {{-- Overlay terjual --}}
                @if($product->is_sold)
                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                        <span class="bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full tracking-wide">TERJUAL</span>
                    </div>
                @elseif(isset($condMap[$product->condition]))
                    <span class="absolute top-2 left-2 {{ $condMap[$product->condition][1] }} text-white text-xs font-semibold px-2 py-0.5 rounded-md shadow-sm">
                        {{ $condMap[$product->condition][0] }}
                    </span>
                @endif
            </a>

            {{-- Info --}}
            <div class="p-3 flex flex-col flex-1">
                <a href="{{ route('products.show', $product) }}"
                   class="text-sm font-semibold text-gray-800 hover:text-blue-600 leading-snug mb-1 transition line-clamp-2">
                    {{ $product->title }}
                </a>
                <p class="text-sm font-bold text-blue-600 mb-1">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </p>
                <p class="text-xs text-gray-400 mb-3 flex items-center gap-1 truncate">
                    <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                    </svg>
                    {{ $product->location }}
                </p>

                {{-- Tombol --}}
                <div class="mt-auto flex gap-2">
                    <a href="{{ route('products.edit', $product) }}"
                       class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold text-center py-2 rounded-lg transition">
                        Edit
                    </a>
                    <form action="{{ route('products.destroy', $product) }}" method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus produk ini?')" class="flex-1">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="w-full bg-red-500 hover:bg-red-600 text-white text-xs font-semibold py-2 rounded-lg transition">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>

        </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>

    @else
    <div class="bg-white rounded-xl border border-gray-200 py-16 text-center">
        <svg class="w-14 h-14 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
        </svg>
        <p class="text-gray-600 font-medium mb-1">Kamu belum punya produk</p>
        <p class="text-sm text-gray-400 mb-5">Mulai pasang iklan dan jual gadgetmu sekarang</p>
        <a href="{{ route('products.create') }}"
           class="inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Pasang Iklan Pertama
        </a>
    </div>
    @endif

</div>
@endsection
