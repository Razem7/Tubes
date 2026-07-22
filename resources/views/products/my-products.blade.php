@extends('layouts.app')
@section('title', 'Produk Saya — GadgetHub')

@section('content')
<div class="page-container py-8">

    {{-- Header --}}
    <div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="section-eyebrow">Akun</p>
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Produk Saya</h1>
            <p class="mt-0.5 text-sm text-slate-500">Kelola semua iklan yang kamu pasang</p>
        </div>
        <a href="{{ route('products.create') }}" class="btn-primary self-start py-2.5 px-5 text-sm">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Pasang Iklan Baru
        </a>
    </div>

    @if($products->count() > 0)

    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5">
        @foreach($products as $product)
        @php
            $photo  = $product->photos->first();
            // photo_url accessor returns an absolute path e.g. /storage/products/xyz.jpg
            // Do NOT wrap in asset() — that would double the base URL
            $imgSrc = $photo ? $photo->photo_url : null;

            $condBadge = [
                'new'      => ['Baru',       'bg-emerald-50 text-emerald-700 border-emerald-200/60'],
                'like_new' => ['Spt Baru',   'bg-brand-50   text-brand-700   border-brand-200/60'],
                'good'     => ['Baik',        'bg-amber-50   text-amber-700   border-amber-200/60'],
                'fair'     => ['Cukup Baik',  'bg-orange-50  text-orange-700  border-orange-200/60'],
            ];
            $badge = $condBadge[$product->condition] ?? null;
        @endphp

        <div class="group flex flex-col overflow-hidden rounded-3xl border border-slate-200/60 bg-white shadow-card
                    transition-all duration-350 ease-spring hover:-translate-y-1 hover:shadow-card-hover">

            {{-- Thumbnail --}}
            <div class="relative overflow-hidden bg-slate-100" style="aspect-ratio:1/1;">
                <a href="{{ route('products.show', $product) }}">
                    @if($imgSrc)
                        <img src="{{ $imgSrc }}"
                             alt="{{ $product->title }}"
                             loading="lazy"
                             class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                             onerror="this.style.display='none'">
                    @else
                        <div class="flex h-full w-full flex-col items-center justify-center text-slate-300">
                            <svg class="h-10 w-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="mt-1.5 text-[10px] font-semibold text-slate-400">Belum ada foto</span>
                        </div>
                    @endif
                </a>

                {{-- Sold overlay --}}
                @if($product->is_sold)
                <div class="absolute inset-0 flex items-center justify-center bg-slate-900/55 backdrop-blur-[2px]">
                    <span class="rounded-full bg-rose-600 px-3.5 py-1 text-[10px] font-extrabold uppercase tracking-widest text-white shadow-lg">
                        Terjual
                    </span>
                </div>
                @elseif($badge)
                <span class="absolute left-2.5 top-2.5 rounded-xl border px-2 py-0.5 text-[10px] font-bold shadow-sm backdrop-blur-sm {{ $badge[1] }}">
                    {{ $badge[0] }}
                </span>
                @endif
            </div>

            {{-- Card body --}}
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

                {{-- Actions --}}
                <div class="mt-auto flex gap-2 border-t border-slate-100 pt-3">
                    <a href="{{ route('products.edit', $product) }}"
                       class="flex-1 inline-flex items-center justify-center rounded-2xl border border-brand-200
                              bg-brand-50 py-2 text-xs font-semibold text-brand-700
                              transition-colors hover:bg-brand-100 active:scale-95">
                        Edit
                    </a>
                    <form action="{{ route('products.destroy', $product) }}" method="POST"
                          onsubmit="return confirm('Hapus produk ini secara permanen?')" class="flex-1">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="w-full rounded-2xl border border-rose-200 bg-rose-50 py-2
                                       text-xs font-semibold text-rose-600
                                       transition-colors hover:bg-rose-100 active:scale-95">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if($products->hasPages())
    <div class="mt-10 flex justify-center border-t border-slate-100 pt-6">
        {{ $products->withQueryString()->links() }}
    </div>
    @endif

    @else

    {{-- Empty state --}}
    <div class="empty-state py-24">
        <div class="empty-state-icon">
            <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
        </div>
        <h3 class="empty-state-title">Belum ada produk</h3>
        <p class="empty-state-desc">Mulai pasang iklan dan jual gadgetmu sekarang</p>
        <a href="{{ route('products.create') }}" class="btn-primary mt-6 py-2.5 px-6 text-sm">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Pasang Iklan Pertama
        </a>
    </div>

    @endif

</div>
@endsection
