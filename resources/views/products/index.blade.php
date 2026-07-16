@extends('layouts.app')

@section('title', 'GadgetHub - Marketplace Gadget Bekas')

@section('content')

{{-- Banner / Hero --}}
@if($banners->count() > 0)
@php $banner = $banners->first(); @endphp
<div class="bg-gray-900 py-3">
    <div class="max-w-screen-xl mx-auto px-4">
        @if($banner->link_url)
            <a href="{{ $banner->link_url }}" target="_blank" class="block">
        @endif
            <img src="{{ asset('storage/' . $banner->image_url) }}"
                 alt="{{ $banner->title }}"
                 class="w-full object-contain rounded-xl mx-auto"
                 style="max-height: 260px; display: block;">
        @if($banner->link_url)
            </a>
        @endif
    </div>
</div>
@else
{{-- Fallback hero jika belum ada banner --}}
<div class="py-8 px-4" style="background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 60%, #3b82f6 100%);">
    <div class="max-w-screen-xl mx-auto text-center">
        <h1 class="text-xl md:text-2xl font-bold text-white mb-1">Temukan Barang Elektronik Bekas Terbaik</h1>
        <p class="text-blue-100 text-sm">Transaksi aman, harga terjangkau, pilihan terlengkap.</p>
    </div>
</div>
@endif

{{-- Category Chips --}}
<div class="bg-white border-b border-gray-200 sticky top-16 z-40">
    <div class="max-w-screen-xl mx-auto px-4">
        <div class="flex items-center gap-2 overflow-x-auto py-3" style="scrollbar-width:none; -ms-overflow-style:none;">
            <a href="{{ route('products.index', request()->except('category_id','page')) }}"
               class="flex-shrink-0 px-4 py-1.5 rounded-full text-sm font-medium border transition-all
                      {{ !request('category_id') ? 'bg-blue-600 text-white border-blue-600 shadow-sm' : 'bg-white text-gray-600 border-gray-300 hover:border-blue-400 hover:text-blue-600' }}">
                Semua
            </a>
            @foreach($categories as $cat)
            <a href="{{ route('products.index', array_merge(request()->except('category_id','page'), ['category_id' => $cat->id])) }}"
               class="flex-shrink-0 px-4 py-1.5 rounded-full text-sm font-medium border transition-all
                      {{ request('category_id') == $cat->id ? 'bg-blue-600 text-white border-blue-600 shadow-sm' : 'bg-white text-gray-600 border-gray-300 hover:border-blue-400 hover:text-blue-600' }}">
                {{ $cat->name }}
            </a>
            @endforeach
        </div>
    </div>
</div>

{{-- Main --}}
<div class="max-w-screen-xl mx-auto px-4 py-5">

    {{-- Toolbar --}}
    <div class="flex items-center justify-between mb-4">
        <p class="text-sm text-gray-500">
            <span class="font-semibold text-gray-800">{{ $products->total() }}</span> produk ditemukan
        </p>
        <div class="flex items-center gap-2">
            {{-- Active filter count badge --}}
            @php
                $activeFilters = array_filter(request()->only(['search','location','min_price','max_price','condition','brand']));
            @endphp
            <button onclick="toggleFilters()"
                    class="flex items-center gap-1.5 text-sm border px-3 py-1.5 rounded-lg transition
                           {{ count($activeFilters) ? 'bg-blue-50 border-blue-400 text-blue-700 font-medium' : 'bg-white border-gray-300 text-gray-600 hover:bg-gray-50' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 4h18M6 8h12M9 12h6M12 16h.01"/>
                </svg>
                Filter
                @if(count($activeFilters))
                    <span class="bg-blue-600 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center">{{ count($activeFilters) }}</span>
                @endif
            </button>
            @if(count($activeFilters) || request('category_id'))
                <a href="{{ route('products.index') }}"
                   class="text-xs text-red-500 hover:text-red-700 border border-red-200 hover:border-red-400 px-3 py-1.5 rounded-lg transition bg-red-50">
                    Reset
                </a>
            @endif
        </div>
    </div>

    {{-- Active filter badges --}}
    @if(count($activeFilters))
    <div class="flex flex-wrap gap-2 mb-4">
        @if(request('search'))
        <span class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 border border-blue-200 text-xs px-3 py-1 rounded-full">
            🔍 {{ request('search') }}
            <a href="{{ route('products.index', request()->except('search','page')) }}" class="ml-1 font-bold hover:text-blue-900">×</a>
        </span>
        @endif
        @if(request('location'))
        <span class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 border border-blue-200 text-xs px-3 py-1 rounded-full">
            📍 {{ request('location') }}
            <a href="{{ route('products.index', request()->except('location','page')) }}" class="ml-1 font-bold hover:text-blue-900">×</a>
        </span>
        @endif
        @if(request('condition'))
        @php $cl = ['new'=>'Baru','like_new'=>'Seperti Baru','good'=>'Baik','fair'=>'Cukup Baik']; @endphp
        <span class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 border border-blue-200 text-xs px-3 py-1 rounded-full">
            {{ $cl[request('condition')] ?? request('condition') }}
            <a href="{{ route('products.index', request()->except('condition','page')) }}" class="ml-1 font-bold hover:text-blue-900">×</a>
        </span>
        @endif
        @if(request('min_price') || request('max_price'))
        <span class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 border border-blue-200 text-xs px-3 py-1 rounded-full">
            Rp {{ number_format(request('min_price',0),0,',','.') }}–{{ request('max_price') ? number_format(request('max_price'),0,',','.') : '∞' }}
            <a href="{{ route('products.index', request()->except('min_price','max_price','page')) }}" class="ml-1 font-bold hover:text-blue-900">×</a>
        </span>
        @endif
    </div>
    @endif

    {{-- Collapsible Filter Panel --}}
    <div id="filter-panel" class="{{ count($activeFilters) ? '' : 'hidden' }} mb-5">
        <form action="{{ route('products.index') }}" method="GET"
              class="bg-white rounded-2xl border border-gray-200 p-4 shadow-sm">
            @if(request('category_id'))
                <input type="hidden" name="category_id" value="{{ request('category_id') }}">
            @endif
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Kata kunci"
                       class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 col-span-2 md:col-span-1">
                <input type="text" name="location" value="{{ request('location') }}" placeholder="Lokasi"
                       class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                <input type="text" name="brand" value="{{ request('brand') }}" placeholder="Brand"
                       class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                <select name="condition" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">Semua Kondisi</option>
                    <option value="new"      {{ request('condition')=='new'      ? 'selected':'' }}>Baru</option>
                    <option value="like_new" {{ request('condition')=='like_new' ? 'selected':'' }}>Seperti Baru</option>
                    <option value="good"     {{ request('condition')=='good'     ? 'selected':'' }}>Baik</option>
                    <option value="fair"     {{ request('condition')=='fair'     ? 'selected':'' }}>Cukup Baik</option>
                </select>
                <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Harga Min"
                       class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Harga Max"
                       class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div class="flex gap-2 mt-3">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-5 py-2 rounded-lg transition">
                    Terapkan Filter
                </button>
                <a href="{{ route('products.index') }}"
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium px-5 py-2 rounded-lg transition">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Product Grid --}}
    @if($products->count() > 0)
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 md:gap-4">
        @foreach($products as $product)
        @php
            $photo = $product->photos->first();
            $imgSrc = ($photo && $photo->photo_url) ? asset($photo->photo_url) : null;
            $condBadge = ['new' => ['Baru','bg-green-500'], 'like_new' => ['Spt Baru','bg-blue-500'], 'good' => ['Baik','bg-yellow-500'], 'fair' => ['Cukup Baik','bg-orange-500']];
            $isMerchant = $product->user && $product->user->isMerchant();
        @endphp
        <a href="{{ route('products.show', $product) }}"
           class="bg-white rounded-xl border border-gray-200 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 group overflow-hidden flex flex-col">

            {{-- Photo --}}
            <div class="relative overflow-hidden bg-gray-100" style="aspect-ratio:1/1;">
                @if($imgSrc)
                    <img src="{{ $imgSrc }}"
                         alt="{{ $product->title }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                         loading="lazy"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="w-full h-full items-center justify-center flex-col text-gray-400 absolute inset-0 bg-gray-100" style="display:none;">
                        <svg class="w-10 h-10 text-gray-300 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-xs">No Image</span>
                    </div>
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center text-gray-400">
                        <svg class="w-10 h-10 text-gray-300 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-xs">No Image</span>
                    </div>
                @endif

                {{-- Badges --}}
                @if($product->is_sold)
                <div class="absolute inset-0 bg-black bg-opacity-45 flex items-center justify-center">
                    <span class="bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full tracking-wide">TERJUAL</span>
                </div>
                @elseif(isset($condBadge[$product->condition]))
                <span class="absolute top-2 left-2 {{ $condBadge[$product->condition][1] }} text-white text-xs font-semibold px-2 py-0.5 rounded-md shadow-sm">
                    {{ $condBadge[$product->condition][0] }}
                </span>
                @endif
            </div>

            {{-- Info --}}
            <div class="p-3 flex flex-col flex-1">
                <p class="text-xs font-semibold text-gray-800 leading-snug line-clamp-2 group-hover:text-blue-600 transition-colors mb-1.5">
                    {{ $product->title }}
                </p>
                <p class="text-sm font-bold text-blue-600 mb-2">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </p>
                <div class="mt-auto space-y-1">
                    {{-- Seller info dengan badge role --}}
                    <div class="flex items-center gap-1">
                        @if($isMerchant)
                            <span class="inline-flex items-center gap-0.5 bg-purple-100 text-purple-700 text-xs font-semibold px-1.5 py-0.5 rounded flex-shrink-0">
                                <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/><path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/></svg>
                                Toko
                            </span>
                        @endif
                        <span class="text-xs text-gray-500 truncate">{{ $product->user->name ?? '-' }}</span>
                    </div>
                    {{-- Lokasi & Kategori --}}
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-400 truncate max-w-[70%]">{{ $product->location }}</span>
                        @if($product->category)
                        <span class="text-xs bg-gray-100 text-gray-500 px-1.5 py-0.5 rounded flex-shrink-0">{{ $product->category->name }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    <div class="mt-8 flex justify-center">
        {{ $products->withQueryString()->links() }}
    </div>

    @else
    <div class="bg-white rounded-2xl border border-gray-200 py-16 text-center">
        <svg class="w-14 h-14 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
        </svg>
        <p class="text-gray-600 font-medium">Tidak ada produk ditemukan</p>
        <p class="text-sm text-gray-400 mt-1">Coba ubah filter atau kata kunci pencarian</p>
        <a href="{{ route('products.index') }}"
           class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-5 py-2 rounded-lg transition">
            Lihat semua produk
        </a>
    </div>
    @endif
</div>

@push('scripts')
<script>
function toggleFilters() {
    document.getElementById('filter-panel').classList.toggle('hidden');
}
</script>
@endpush

@endsection
