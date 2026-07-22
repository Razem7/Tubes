@extends('layouts.merchant')
@section('title', 'Manajemen Stok — Merchant GadgetHub')

@section('content')

{{-- Header --}}
<div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <p class="section-eyebrow">Inventori</p>
        <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Manajemen Stok</h1>
        <p class="mt-0.5 text-sm text-slate-500">Update jumlah stok setiap produkmu</p>
    </div>
    <a href="{{ route('merchant.products.create') }}" class="btn-merchant self-start">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Produk
    </a>
</div>

{{-- Filter --}}
<div class="card mb-6 p-4">
    <form action="{{ route('merchant.stock') }}" method="GET"
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
        <button type="submit" class="btn-merchant py-2.5 px-5 text-sm">Cari</button>
        @if(request('search'))
        <a href="{{ route('merchant.stock') }}" class="btn-secondary py-2.5 px-4 text-sm">Reset</a>
        @endif
    </form>
</div>

{{-- Table --}}
<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th class="pl-5">Produk</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Status</th>
                    <th class="pr-5">Update Stok</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                @php $photo = $product->photos->first(); @endphp
                <tr>
                    <td class="pl-5">
                        <div class="flex items-center gap-3">
                            <div class="h-11 w-11 flex-shrink-0 overflow-hidden rounded-xl bg-slate-100">
                                @if($photo && $photo->photo_url)
                                    <img src="{{ $photo->photo_url }}"
                                         class="h-full w-full object-cover"
                                         onerror="this.style.display='none'">
                                @endif
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-slate-800 truncate max-w-[200px]">
                                    {{ $product->title }}
                                </p>
                                <p class="text-xs text-slate-400">{{ $product->category->name ?? '—' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="whitespace-nowrap text-sm font-medium text-slate-700">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </td>
                    <td>
                        <span class="text-lg font-extrabold
                            {{ ($product->stock ?? 0) <= 0 ? 'text-rose-500' : (($product->stock ?? 0) <= 3 ? 'text-amber-500' : 'text-slate-800') }}">
                            {{ $product->stock ?? 0 }}
                        </span>
                        @if(($product->stock ?? 0) <= 3 && ($product->stock ?? 0) > 0)
                        <span class="ml-1 text-[10px] font-bold text-amber-500">hampir habis</span>
                        @elseif(($product->stock ?? 0) <= 0)
                        <span class="ml-1 text-[10px] font-bold text-rose-500">kosong</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge {{ $product->is_sold ? 'badge-red' : 'badge-emerald' }}">
                            {{ $product->is_sold ? 'Terjual' : 'Aktif' }}
                        </span>
                    </td>
                    <td class="pr-5">
                        <form action="{{ route('merchant.stock.update', $product) }}" method="POST"
                              class="flex items-center gap-2">
                            @csrf @method('PATCH')
                            <input type="number" name="stock" value="{{ $product->stock ?? 0 }}" min="0"
                                   class="w-20 rounded-xl border border-slate-200 bg-white px-3 py-1.5 text-sm text-center font-semibold text-slate-700 outline-none transition-all focus:border-purple-400 focus:ring-2 focus:ring-purple-400/20">
                            <button type="submit"
                                    class="whitespace-nowrap rounded-xl bg-purple-600 px-3.5 py-1.5 text-xs font-bold text-white transition-colors hover:bg-purple-700 active:scale-95">
                                Simpan
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-14 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100">
                                <svg class="h-6 w-6 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                            <p class="text-sm font-semibold text-slate-500">Belum ada produk</p>
                            <a href="{{ route('merchant.products.create') }}"
                               class="text-xs font-semibold text-purple-600 hover:underline">
                                Tambah produk pertama →
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($products->hasPages())
<div class="mt-6 flex justify-center border-t border-slate-100 pt-6">
    {{ $products->withQueryString()->links() }}
</div>
@endif

@endsection
