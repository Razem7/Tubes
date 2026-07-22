@extends('layouts.merchant')
@section('title', 'Produk Saya — Merchant GadgetHub')

@section('content')

{{-- Header --}}
<div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <p class="section-eyebrow">Toko Saya</p>
        <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Produk Saya</h1>
        <p class="mt-0.5 text-sm text-slate-500">Kelola semua produk yang kamu jual</p>
    </div>
    <a href="{{ route('merchant.products.create') }}" class="btn-merchant self-start">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Produk
    </a>
</div>

{{-- Filter Bar --}}
<div class="card mb-6 p-4">
    <form action="{{ route('merchant.products') }}" method="GET"
          class="flex flex-wrap items-center gap-3">
        <div class="relative flex-1 min-w-[180px]">
            <div class="pointer-events-none absolute inset-y-0 left-3.5 flex items-center text-slate-400">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/>
                </svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari produk…"
                   class="input-field py-2.5 pl-10">
        </div>
        <select name="status" class="input-field w-auto min-w-[140px] py-2.5">
            <option value="">Semua Status</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
            <option value="sold"   {{ request('status') === 'sold'   ? 'selected' : '' }}>Terjual</option>
        </select>
        <button type="submit" class="btn-merchant py-2.5 px-5 text-sm">Cari</button>
        @if(request('search') || request('status'))
        <a href="{{ route('merchant.products') }}" class="btn-secondary py-2.5 px-4 text-sm">Reset</a>
        @endif
    </form>
</div>

{{-- Products Grid --}}
@if($products->count())

<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mb-6">
    @foreach($products as $product)
    @php $photo = $product->photos->first(); @endphp
    <div class="card group flex flex-col transition-all duration-300 hover:-translate-y-1 hover:shadow-card-hover">

        {{-- Thumbnail --}}
        <div class="relative overflow-hidden bg-slate-100" style="aspect-ratio:4/3;">
            @if($photo && $photo->photo_url)
                <img src="{{ $photo->photo_url }}"
                     alt="{{ $product->title }}"
                     class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                     onerror="this.style.display='none'">
            @else
                <div class="flex h-full w-full flex-col items-center justify-center text-slate-300">
                    <svg class="h-10 w-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            @endif
            {{-- Status badge --}}
            <span class="absolute left-2.5 top-2.5 rounded-xl px-2.5 py-0.5 text-[10px] font-extrabold
                         {{ $product->is_sold ? 'bg-rose-500 text-white' : 'bg-emerald-500 text-white' }}">
                {{ $product->is_sold ? 'Terjual' : 'Aktif' }}
            </span>
        </div>

        {{-- Body --}}
        <div class="flex flex-1 flex-col p-4">
            <p class="line-clamp-2 text-sm font-bold text-slate-800 leading-snug min-h-[2.4rem]">
                {{ $product->title }}
            </p>
            <p class="mt-1.5 text-sm font-extrabold text-purple-600">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </p>
            <div class="mt-1 flex items-center gap-2 text-xs text-slate-400">
                <span>Stok: <span class="font-semibold text-slate-600">{{ $product->stock ?? '—' }}</span></span>
                <span class="text-slate-200">·</span>
                <span class="truncate">{{ $product->category->name ?? '—' }}</span>
            </div>

            {{-- Actions --}}
            <div class="mt-4 flex gap-2 border-t border-slate-100 pt-3.5">
                <a href="{{ route('merchant.products.edit', $product) }}"
                   class="flex-1 inline-flex items-center justify-center gap-1.5 rounded-2xl border border-purple-200 bg-purple-50 py-2 text-xs font-semibold text-purple-700 transition-colors hover:bg-purple-100">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit
                </a>
                <form action="{{ route('merchant.products.destroy', $product) }}" method="POST"
                      onsubmit="return confirm('Hapus produk ini? Tindakan tidak dapat dibatalkan.')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center justify-center gap-1.5 rounded-2xl border border-rose-200 bg-rose-50 px-3 py-2 text-xs font-semibold text-rose-600 transition-colors hover:bg-rose-100">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Pagination --}}
<div class="flex justify-center border-t border-slate-100 pt-6">
    {{ $products->withQueryString()->links() }}
</div>

@else

{{-- Empty State --}}
<div class="empty-state py-20">
    <div class="empty-state-icon bg-purple-50 text-purple-500">
        <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
        </svg>
    </div>
    <h3 class="empty-state-title">
        {{ request('search') || request('status') ? 'Produk tidak ditemukan' : 'Belum ada produk' }}
    </h3>
    <p class="empty-state-desc">
        {{ request('search') || request('status') ? 'Coba ubah filter atau kata kunci pencarian.' : 'Mulai jualan dengan menambahkan produk pertamamu.' }}
    </p>
    <div class="mt-6 flex justify-center gap-3">
        @if(request('search') || request('status'))
            <a href="{{ route('merchant.products') }}" class="btn-secondary py-2.5 px-5 text-sm">Reset Filter</a>
        @endif
        <a href="{{ route('merchant.products.create') }}" class="btn-merchant py-2.5 px-6 text-sm">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Produk
        </a>
    </div>
</div>

@endif
@endsection
