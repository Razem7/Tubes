@extends('layouts.app')
@section('title', 'Favorit Saya — GadgetHub')

@section('content')
<div class="page-container py-8">

    {{-- Header --}}
    <div class="mb-7 flex items-center justify-between">
        <div>
            <p class="section-eyebrow">Wishlist</p>
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Produk Favorit</h1>
            <p class="mt-0.5 text-sm text-slate-500">
                {{ $favorites->total() > 0 ? number_format($favorites->total()).' produk tersimpan' : 'Belum ada produk favorit' }}
            </p>
        </div>
        <a href="{{ route('products.index') }}" class="btn-secondary py-2 px-4 text-sm">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/>
            </svg>
            Jelajahi Produk
        </a>
    </div>

    @if($favorites->count() > 0)

    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5">
        @foreach($favorites as $favorite)
        @php
            $product = $favorite->product;
            $photo   = $product->photos->first();
            // photo_url accessor returns absolute path — use directly, no asset() wrapper
            $imgSrc  = $photo ? $photo->photo_url : null;
            $condBadge = [
                'new'      => ['Baru',      'bg-emerald-50 text-emerald-700 border-emerald-200/60'],
                'like_new' => ['Spt Baru',  'bg-brand-50   text-brand-700   border-brand-200/60'],
                'good'     => ['Baik',       'bg-amber-50   text-amber-700   border-amber-200/60'],
                'fair'     => ['Cukup Baik', 'bg-orange-50  text-orange-700  border-orange-200/60'],
            ];
            $badge = $condBadge[$product->condition] ?? null;
        @endphp

        <div class="group flex flex-col overflow-hidden rounded-3xl border border-slate-200/60 bg-white shadow-card
                    transition-all duration-350 ease-spring hover:-translate-y-1 hover:shadow-card-hover">

            {{-- Thumbnail --}}
            <div class="relative overflow-hidden bg-slate-100" style="aspect-ratio:1/1;">
                @if($imgSrc)
                    <a href="{{ route('products.show', $product) }}">
                        <img src="{{ $imgSrc }}"
                             alt="{{ $product->title }}"
                             loading="lazy"
                             class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                             onerror="this.style.display='none'">
                    </a>
                @else
                    <a href="{{ route('products.show', $product) }}"
                       class="flex h-full w-full flex-col items-center justify-center text-slate-300">
                        <svg class="h-10 w-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </a>
                @endif

                {{-- Sold overlay --}}
                @if($product->is_sold)
                <div class="absolute inset-0 flex items-center justify-center bg-slate-900/55 backdrop-blur-[2px]">
                    <span class="rounded-full bg-rose-600 px-3.5 py-1 text-[10px] font-extrabold uppercase tracking-widest text-white">Terjual</span>
                </div>
                @elseif($badge)
                <span class="absolute left-2.5 top-2.5 rounded-xl border px-2 py-0.5 text-[10px] font-bold shadow-sm backdrop-blur-sm {{ $badge[1] }}">
                    {{ $badge[0] }}
                </span>
                @endif

                {{-- Remove from favorites --}}
                <form action="{{ route('favorites.toggle', $product) }}" method="POST"
                      class="absolute right-2.5 top-2.5">
                    @csrf
                    <button type="submit"
                            title="Hapus dari favorit"
                            class="flex h-8 w-8 items-center justify-center rounded-full bg-white/90 text-rose-500 shadow-sm backdrop-blur-sm transition-all hover:bg-rose-50 hover:scale-110 active:scale-95">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </form>
            </div>

            {{-- Body --}}
            <div class="flex flex-1 flex-col p-3.5">
                <a href="{{ route('products.show', $product) }}"
                   class="line-clamp-2 min-h-[2.4rem] text-xs font-bold leading-snug text-slate-900 transition-colors hover:text-brand-700">
                    {{ $product->title }}
                </a>
                <p class="mt-1.5 text-sm font-extrabold text-brand-600">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </p>
                <p class="mt-1 flex items-center gap-1 truncate text-[10px] text-slate-400">
                    <svg class="h-3 w-3 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    {{ $product->location }}
                </p>
            </div>
        </div>
        @endforeach
    </div>

    @if($favorites->hasPages())
    <div class="mt-10 flex justify-center border-t border-slate-100 pt-6">
        {{ $favorites->withQueryString()->links() }}
    </div>
    @endif

    @else

    <div class="empty-state py-24">
        <div class="empty-state-icon bg-rose-50 text-rose-400">
            <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
        </div>
        <h3 class="empty-state-title">Belum ada favorit</h3>
        <p class="empty-state-desc">Tap ikon hati di produk untuk menyimpannya di sini</p>
        <a href="{{ route('products.index') }}" class="btn-primary mt-6 py-2.5 px-6 text-sm">
            Jelajahi Produk
        </a>
    </div>

    @endif
</div>
@endsection
