@extends('layouts.app')

@section('title', 'GadgetHub — Marketplace Gadget Bekas Terpercaya')
@section('description', 'Beli dan jual gadget bekas berkualitas. Temukan HP, laptop, tablet, dan aksesori dengan harga terbaik dari penjual terverifikasi.')

@section('content')
@php
    $activeFilters = array_filter(request()->only(['search','location','min_price','max_price','condition','brand']));

    // Condition badge config
    $condBadge = [
        'new'      => ['label' => 'Baru',       'class' => 'bg-emerald-50 text-emerald-700 border-emerald-200/60'],
        'like_new' => ['label' => 'Spt Baru',   'class' => 'bg-brand-50  text-brand-700  border-brand-200/60'],
        'good'     => ['label' => 'Baik',        'class' => 'bg-amber-50  text-amber-700  border-amber-200/60'],
        'fair'     => ['label' => 'Cukup Baik',  'class' => 'bg-orange-50 text-orange-700 border-orange-200/60'],
    ];
    $condLabels = ['new'=>'Baru','like_new'=>'Seperti Baru','good'=>'Baik','fair'=>'Cukup Baik'];
@endphp

{{-- ═══════════════════════════════════════════════════
     HERO — Banner (if set) OR Default Hero
═══════════════════════════════════════════════════ --}}
<section class="page-container pt-6">
@if($banners->count() > 0)
    @php $banner = $banners->first(); @endphp
    <div class="overflow-hidden rounded-4xl border border-slate-200/60 bg-white shadow-panel">
        @if($banner->link_url)
            <a href="{{ $banner->link_url }}" target="_blank" rel="noopener" class="block">
        @endif
        <img src="{{ \Storage::url($banner->image_url) }}"
             alt="{{ $banner->title }}"
             class="block w-full object-cover"
             style="max-height:320px;">
        @if($banner->link_url)
            </a>
        @endif
    </div>
@else
    {{-- ── Default Premium Hero ── --}}
    <div class="relative overflow-hidden rounded-4xl bg-gradient-to-br from-brand-950 via-brand-900 to-slate-900 text-white">

        {{-- Decorative blobs --}}
        <div class="pointer-events-none absolute -right-24 -top-24 h-80 w-80 rounded-full bg-brand-500/20 blur-3xl"></div>
        <div class="pointer-events-none absolute -left-24 bottom-0 h-72 w-72 rounded-full bg-accent-500/10 blur-3xl"></div>
        <div class="pointer-events-none absolute right-1/3 top-1/2 h-48 w-48 -translate-y-1/2 rounded-full bg-accent-400/10 blur-2xl"></div>

        <div class="relative px-8 py-12 md:px-14 md:py-16 lg:py-20">
            <div class="flex flex-col gap-10 lg:flex-row lg:items-center lg:justify-between">

                {{-- Copy --}}
                <div class="max-w-2xl space-y-5">
                    <span class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/8 px-4 py-1.5 text-xs font-semibold tracking-wide text-brand-200 backdrop-blur-sm">
                        <span class="h-1.5 w-1.5 animate-pulse rounded-full bg-accent-400"></span>
                        Marketplace Gadget Bekas #1 Indonesia
                    </span>

                    <h1 class="text-3xl font-extrabold leading-tight tracking-tight text-white sm:text-4xl md:text-5xl">
                        Temukan Gadget Impian<br>
                        <span class="bg-gradient-to-r from-accent-400 to-brand-300 bg-clip-text text-transparent">
                            Dengan Harga Terbaik.
                        </span>
                    </h1>

                    <p class="max-w-lg text-sm leading-relaxed text-slate-300 md:text-base">
                        Jelajahi ribuan HP, laptop, tablet, dan aksesori bekas berkualitas. Penjual terverifikasi, transaksi aman, pengiriman ke seluruh Indonesia.
                    </p>

                    {{-- Hero CTA --}}
                    <div class="flex flex-wrap items-center gap-3 pt-1">
                        <a href="{{ route('products.index') }}"
                           class="inline-flex items-center gap-2 rounded-2xl bg-white px-6 py-3 text-sm font-bold text-brand-700 shadow-lg shadow-black/20 transition-all hover:-translate-y-0.5 hover:shadow-xl">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/>
                            </svg>
                            Jelajahi Produk
                        </a>
                        <a href="{{ route('products.create') }}"
                           class="inline-flex items-center gap-2 rounded-2xl border border-white/20 bg-white/10 px-6 py-3 text-sm font-semibold text-white backdrop-blur-sm transition-all hover:bg-white/20">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            Pasang Iklan
                        </a>
                    </div>

                    {{-- Trust badges --}}
                    <div class="flex flex-wrap gap-4 pt-2">
                        <span class="flex items-center gap-1.5 text-xs font-medium text-slate-400">
                            <svg class="h-4 w-4 text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            Penjual Terverifikasi
                        </span>
                        <span class="flex items-center gap-1.5 text-xs font-medium text-slate-400">
                            <svg class="h-4 w-4 text-sky-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            Chat Langsung
                        </span>
                        <span class="flex items-center gap-1.5 text-xs font-medium text-slate-400">
                            <svg class="h-4 w-4 text-amber-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            COD &amp; Rekber
                        </span>
                    </div>
                </div>

                {{-- Stats --}}
                <div class="grid grid-cols-3 gap-3 lg:w-72 lg:flex-shrink-0 lg:grid-cols-1 lg:gap-4">
                    <div class="rounded-3xl border border-white/8 bg-white/6 p-5 text-center backdrop-blur-md lg:text-left">
                        <p class="text-2xl font-extrabold tracking-tight text-white lg:text-3xl">{{ number_format($products->total()) }}</p>
                        <p class="mt-1 text-[10px] font-bold uppercase tracking-widest text-slate-400">Produk Aktif</p>
                    </div>
                    <div class="rounded-3xl border border-white/8 bg-white/6 p-5 text-center backdrop-blur-md lg:text-left">
                        <p class="text-2xl font-extrabold tracking-tight text-white lg:text-3xl">{{ $categories->count() }}+</p>
                        <p class="mt-1 text-[10px] font-bold uppercase tracking-widest text-slate-400">Kategori</p>
                    </div>
                    <div class="rounded-3xl border border-white/8 bg-white/6 p-5 text-center backdrop-blur-md lg:text-left">
                        <p class="text-2xl font-extrabold tracking-tight text-white lg:text-3xl">100%</p>
                        <p class="mt-1 text-[10px] font-bold uppercase tracking-widest text-slate-400">Aman</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endif
</section>

{{-- ═══════════════════════════════════════════════════
     STICKY CATEGORY BAR
═══════════════════════════════════════════════════ --}}
<div class="sticky top-16 z-40 mt-5 border-b border-slate-200/60 bg-white/85 backdrop-blur-xl">
    <div class="page-container">
        <div class="no-scrollbar flex items-center gap-2 overflow-x-auto py-3">

            <a href="{{ route('products.index', request()->except('category_id','page')) }}"
               class="flex-shrink-0 rounded-full border px-4 py-1.5 text-xs font-bold transition-all duration-200 active:scale-95
                      {{ !request('category_id')
                          ? 'border-brand-600 bg-brand-600 text-white shadow-sm shadow-brand-600/20'
                          : 'border-slate-200 bg-white text-slate-600 hover:border-brand-300 hover:text-brand-700' }}">
                Semua Gadget
            </a>

            @foreach($categories as $cat)
            <a href="{{ route('products.index', array_merge(request()->except('category_id','page'), ['category_id' => $cat->id])) }}"
               class="flex-shrink-0 rounded-full border px-4 py-1.5 text-xs font-bold transition-all duration-200 active:scale-95
                      {{ request('category_id') == $cat->id
                          ? 'border-brand-600 bg-brand-600 text-white shadow-sm shadow-brand-600/20'
                          : 'border-slate-200 bg-white text-slate-600 hover:border-brand-300 hover:text-brand-700' }}">
                {{ $cat->name }}
            </a>
            @endforeach

        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════
     MAIN CONTENT
═══════════════════════════════════════════════════ --}}
<div class="page-container py-7">

    {{-- ── Toolbar: count + filter button ── --}}
    <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
        <p class="text-sm text-slate-500">
            @if(count($activeFilters) || request('category_id'))
                <span class="font-bold text-slate-900">{{ number_format($products->total()) }}</span> hasil ditemukan
            @else
                Menampilkan <span class="font-bold text-slate-900">{{ number_format($products->total()) }}</span> produk
            @endif
        </p>

        <div class="flex items-center gap-2">
            <button id="filter-toggle-btn" type="button" onclick="toggleFilters()"
                    class="inline-flex items-center gap-2 rounded-2xl border px-4 py-2 text-xs font-semibold transition-all duration-200 active:scale-95
                           {{ count($activeFilters) ? 'border-brand-200 bg-brand-50 text-brand-700' : 'border-slate-200 bg-white text-slate-600 hover:border-slate-300 hover:bg-slate-50' }}">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                </svg>
                Filter
                @if(count($activeFilters))
                    <span class="flex h-4 w-4 items-center justify-center rounded-full bg-brand-600 text-[9px] font-extrabold text-white">
                        {{ count($activeFilters) }}
                    </span>
                @endif
            </button>

            @if(count($activeFilters) || request('category_id'))
            <a href="{{ route('products.index') }}"
               class="inline-flex items-center gap-1.5 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-2 text-xs font-semibold text-rose-600 transition-all hover:bg-rose-100 active:scale-95">
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Reset
            </a>
            @endif
        </div>
    </div>

    {{-- ── Active filter chips ── --}}
    @if(count($activeFilters))
    <div class="mb-5 flex flex-wrap gap-2">
        @if(request('search'))
        <span class="soft-pill">
            <svg class="h-3.5 w-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/></svg>
            {{ request('search') }}
            <a href="{{ route('products.index', request()->except('search','page')) }}" class="ml-0.5 flex h-4 w-4 items-center justify-center rounded-full text-slate-400 hover:bg-slate-200 hover:text-slate-700">×</a>
        </span>
        @endif
        @if(request('location'))
        <span class="soft-pill">
            📍 {{ request('location') }}
            <a href="{{ route('products.index', request()->except('location','page')) }}" class="ml-0.5 flex h-4 w-4 items-center justify-center rounded-full text-slate-400 hover:bg-slate-200 hover:text-slate-700">×</a>
        </span>
        @endif
        @if(request('brand'))
        <span class="soft-pill">
            Brand: {{ request('brand') }}
            <a href="{{ route('products.index', request()->except('brand','page')) }}" class="ml-0.5 flex h-4 w-4 items-center justify-center rounded-full text-slate-400 hover:bg-slate-200 hover:text-slate-700">×</a>
        </span>
        @endif
        @if(request('condition'))
        <span class="soft-pill">
            {{ $condLabels[request('condition')] ?? request('condition') }}
            <a href="{{ route('products.index', request()->except('condition','page')) }}" class="ml-0.5 flex h-4 w-4 items-center justify-center rounded-full text-slate-400 hover:bg-slate-200 hover:text-slate-700">×</a>
        </span>
        @endif
        @if(request('min_price') || request('max_price'))
        <span class="soft-pill">
            Rp {{ number_format(request('min_price',0),0,',','.') }}
            @if(request('max_price')) – {{ number_format(request('max_price'),0,',','.') }}@else +@endif
            <a href="{{ route('products.index', request()->except('min_price','max_price','page')) }}" class="ml-0.5 flex h-4 w-4 items-center justify-center rounded-full text-slate-400 hover:bg-slate-200 hover:text-slate-700">×</a>
        </span>
        @endif
    </div>
    @endif

    {{-- ── Collapsible Filter Panel ── --}}
    <div id="filter-panel" class="{{ count($activeFilters) ? '' : 'hidden' }} mb-7">
        <form action="{{ route('products.index') }}" method="GET"
              class="rounded-3xl border border-slate-200/70 bg-white p-6 shadow-card">
            @if(request('category_id'))
                <input type="hidden" name="category_id" value="{{ request('category_id') }}">
            @endif
            <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6">
                <div class="form-group">
                    <label class="input-label text-[11px] uppercase tracking-wider text-slate-400">Kata Kunci</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Contoh: iPhone 14" class="input-field py-2.5">
                </div>
                <div class="form-group">
                    <label class="input-label text-[11px] uppercase tracking-wider text-slate-400">Lokasi</label>
                    <input type="text" name="location" value="{{ request('location') }}"
                           placeholder="Kota / Wilayah" class="input-field py-2.5">
                </div>
                <div class="form-group">
                    <label class="input-label text-[11px] uppercase tracking-wider text-slate-400">Brand</label>
                    <input type="text" name="brand" value="{{ request('brand') }}"
                           placeholder="Contoh: Apple" class="input-field py-2.5">
                </div>
                <div class="form-group">
                    <label class="input-label text-[11px] uppercase tracking-wider text-slate-400">Kondisi</label>
                    <select name="condition" class="input-field py-2.5">
                        <option value="">Semua Kondisi</option>
                        <option value="new"      {{ request('condition')=='new'      ? 'selected':'' }}>Baru</option>
                        <option value="like_new" {{ request('condition')=='like_new' ? 'selected':'' }}>Seperti Baru</option>
                        <option value="good"     {{ request('condition')=='good'     ? 'selected':'' }}>Baik (Normal)</option>
                        <option value="fair"     {{ request('condition')=='fair'     ? 'selected':'' }}>Cukup Baik</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="input-label text-[11px] uppercase tracking-wider text-slate-400">Harga Min (Rp)</label>
                    <input type="number" name="min_price" value="{{ request('min_price') }}"
                           placeholder="0" class="input-field py-2.5">
                </div>
                <div class="form-group">
                    <label class="input-label text-[11px] uppercase tracking-wider text-slate-400">Harga Max (Rp)</label>
                    <input type="number" name="max_price" value="{{ request('max_price') }}"
                           placeholder="Tanpa batas" class="input-field py-2.5">
                </div>
            </div>
            <div class="mt-5 flex justify-end gap-2.5 border-t border-slate-100 pt-5">
                <a href="{{ route('products.index') }}" class="btn-secondary py-2 px-5 text-xs">Reset</a>
                <button type="submit" class="btn-primary py-2 px-6 text-xs">Terapkan Filter</button>
            </div>
        </form>
    </div>

    {{-- ═══════════════════════════════════════════════════
         PRODUCT GRID
    ═══════════════════════════════════════════════════ --}}
    @if($products->count() > 0)

    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5">
        @foreach($products as $product)
        @php
            $photo   = $product->photos->first();
            // FIX: photo_url accessor already returns an absolute path like /storage/products/xyz.jpg
            // Using asset() on it would double the base URL. Use the value directly.
            $imgSrc  = $photo ? $photo->photo_url : null;
            $badge   = $condBadge[$product->condition] ?? null;
            $isMerchant = $product->user && $product->user->isMerchant();
        @endphp

        <a href="{{ route('products.show', $product) }}"
           class="group flex flex-col overflow-hidden rounded-3xl border border-slate-200/60 bg-white shadow-card
                  transition-all duration-350 ease-spring
                  hover:-translate-y-1 hover:border-brand-200/60 hover:shadow-card-hover">

            {{-- Product Image --}}
            <div class="relative overflow-hidden bg-slate-100" style="aspect-ratio:1/1;">

                @if($imgSrc)
                    <img src="{{ $imgSrc }}"
                         alt="{{ $product->title }}"
                         class="h-full w-full object-cover transition-transform duration-500 ease-spring group-hover:scale-105"
                         loading="lazy"
                         onerror="this.parentElement.innerHTML='<div class=\'flex h-full w-full flex-col items-center justify-center text-slate-300\'><svg class=\'h-10 w-10\' fill=\'none\' stroke=\'currentColor\' stroke-width=\'1.5\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' d=\'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\'/></svg><span class=\'mt-1.5 text-[10px] font-semibold\'>No Image</span></div>'">
                @else
                    <div class="flex h-full w-full flex-col items-center justify-center text-slate-300">
                        <svg class="h-10 w-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="mt-1.5 text-[10px] font-semibold text-slate-400">Belum ada foto</span>
                    </div>
                @endif

                {{-- Sold overlay --}}
                @if($product->is_sold)
                <div class="absolute inset-0 flex items-center justify-center bg-slate-900/55 backdrop-blur-[2px]">
                    <span class="rounded-full bg-rose-600 px-4 py-1 text-[10px] font-extrabold uppercase tracking-widest text-white shadow-lg shadow-rose-600/30">
                        Terjual
                    </span>
                </div>
                @elseif($badge)
                <span class="absolute left-2.5 top-2.5 rounded-xl border px-2 py-0.5 text-[10px] font-bold shadow-sm backdrop-blur-md {{ $badge['class'] }}">
                    {{ $badge['label'] }}
                </span>
                @endif

                {{-- Favorite hint on hover --}}
                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
            </div>

            {{-- Card Body --}}
            <div class="flex flex-1 flex-col p-3.5 sm:p-4">

                {{-- Title --}}
                <h3 class="line-clamp-2 min-h-[2.4rem] text-xs font-bold leading-snug text-slate-900 transition-colors duration-200 group-hover:text-brand-700">
                    {{ $product->title }}
                </h3>

                {{-- Price --}}
                <p class="mt-1.5 mb-3 text-sm font-extrabold text-brand-600">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </p>

                {{-- Meta --}}
                <div class="mt-auto space-y-1.5 border-t border-slate-100 pt-2.5">

                    {{-- Seller --}}
                    <div class="flex items-center gap-1.5">
                        @if($isMerchant)
                        <span class="inline-flex flex-shrink-0 items-center gap-0.5 rounded-md bg-purple-50 border border-purple-200/50 px-1.5 py-0.5 text-[9px] font-extrabold uppercase text-purple-700">
                            <svg class="h-2.5 w-2.5" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/><path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9z" clip-rule="evenodd"/></svg>
                            Toko
                        </span>
                        @endif
                        <span class="truncate text-[11px] font-semibold text-slate-500">{{ $product->user->name ?? 'Penjual' }}</span>
                    </div>

                    {{-- Location + Category --}}
                    <div class="flex items-center justify-between gap-1.5">
                        <span class="flex min-w-0 items-center gap-1 text-[10px] text-slate-400">
                            <svg class="h-3 w-3 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span class="truncate">{{ $product->location }}</span>
                        </span>
                        @if($product->category)
                        <span class="flex-shrink-0 rounded-lg bg-slate-100 px-1.5 py-0.5 text-[9px] font-bold uppercase tracking-wide text-slate-500">
                            {{ $product->category->name }}
                        </span>
                        @endif
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-12 flex justify-center border-t border-slate-100 pt-8">
        {{ $products->withQueryString()->links() }}
    </div>

    @else

    {{-- ═══════════════════════════════════════════════════
         EMPTY STATE
    ═══════════════════════════════════════════════════ --}}
    <div class="empty-state py-20">
        <div class="empty-state-icon">
            @if(count($activeFilters) || request('category_id'))
                <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            @else
                <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            @endif
        </div>
        <h3 class="empty-state-title text-lg">
            {{ count($activeFilters) || request('category_id') ? 'Produk tidak ditemukan' : 'Belum ada produk' }}
        </h3>
        <p class="empty-state-desc mt-2">
            {{ count($activeFilters) || request('category_id')
                ? 'Coba ubah filter atau kata kunci pencarian kamu.'
                : 'Jadilah yang pertama berjualan di GadgetHub!' }}
        </p>
        <div class="mt-6 flex flex-wrap justify-center gap-3">
            @if(count($activeFilters) || request('category_id'))
            <a href="{{ route('products.index') }}" class="btn-primary py-2.5 px-6 text-sm">
                Reset Filter
            </a>
            @else
            <a href="{{ route('products.create') }}" class="btn-primary py-2.5 px-6 text-sm">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Pasang Iklan Pertama
            </a>
            @endif
        </div>
    </div>

    @endif

</div>{{-- /page-container --}}

{{-- ═══════════════════════════════════════════════════
     CTA SECTION — only on first page with no filters
═══════════════════════════════════════════════════ --}}
@if(!count($activeFilters) && !request('category_id') && !request('search') && $products->currentPage() === 1)
<section class="page-container pb-4">
    <div class="relative overflow-hidden rounded-4xl bg-gradient-to-br from-brand-950 via-brand-900 to-slate-900 px-8 py-12 text-white md:px-14 md:py-14">
        <div class="pointer-events-none absolute -right-20 -top-20 h-64 w-64 rounded-full bg-brand-500/15 blur-3xl"></div>
        <div class="pointer-events-none absolute -left-16 bottom-0 h-56 w-56 rounded-full bg-accent-500/10 blur-3xl"></div>

        <div class="relative flex flex-col items-start justify-between gap-8 md:flex-row md:items-center">
            <div class="max-w-lg space-y-3">
                <h2 class="text-2xl font-extrabold leading-tight tracking-tight text-white md:text-3xl">
                    Punya gadget yang mau dijual?
                </h2>
                <p class="text-sm leading-relaxed text-slate-300">
                    Pasang iklan gratis sekarang. Jutaan pembeli potensial sudah menunggu di GadgetHub.
                </p>
                <ul class="space-y-1.5 text-xs text-slate-400">
                    <li class="flex items-center gap-2"><svg class="h-4 w-4 text-emerald-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg> Gratis pasang iklan tanpa biaya</li>
                    <li class="flex items-center gap-2"><svg class="h-4 w-4 text-emerald-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg> Upload hingga 8 foto produk</li>
                    <li class="flex items-center gap-2"><svg class="h-4 w-4 text-emerald-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg> Chat langsung dengan pembeli</li>
                </ul>
            </div>
            <div class="flex flex-col gap-3 sm:flex-row md:flex-col md:items-stretch">
                <a href="{{ route('products.create') }}"
                   class="inline-flex items-center justify-center gap-2 rounded-2xl bg-white px-7 py-3.5 text-sm font-bold text-brand-700 shadow-lg shadow-black/20 transition-all hover:-translate-y-0.5 hover:shadow-xl">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Pasang Iklan Gratis
                </a>
                @guest
                <a href="{{ route('register') }}"
                   class="inline-flex items-center justify-center gap-2 rounded-2xl border border-white/20 bg-white/10 px-7 py-3.5 text-sm font-semibold text-white backdrop-blur-sm transition-all hover:bg-white/20">
                    Daftar Sekarang
                </a>
                @endguest
            </div>
        </div>
    </div>
</section>
@endif

@push('scripts')
<script>
function toggleFilters() {
    const panel = document.getElementById('filter-panel');
    panel.classList.toggle('hidden');
    // Auto-focus first input when opening
    if (!panel.classList.contains('hidden')) {
        panel.querySelector('input')?.focus();
    }
}
</script>
@endpush

@endsection
