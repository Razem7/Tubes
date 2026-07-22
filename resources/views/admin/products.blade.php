@extends('layouts.admin')
@section('title', 'Kelola Produk — Super Admin GadgetHub')

@section('content')

{{-- Header --}}
<div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <p class="section-eyebrow text-rose-600">Manajemen</p>
        <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Kelola Produk</h1>
        <p class="mt-0.5 text-sm text-slate-500">
            Total <span class="font-bold text-slate-800">{{ $products->total() }}</span> produk di platform
        </p>
    </div>
</div>

{{-- Search --}}
<div class="card mb-6 p-4">
    <form action="{{ route('admin.products') }}" method="GET"
          class="flex flex-wrap items-center gap-3">
        <div class="relative flex-1 min-w-[200px]">
            <div class="pointer-events-none absolute inset-y-0 left-3.5 flex items-center text-slate-400">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/>
                </svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari judul produk atau penjual…"
                   class="input-field py-2.5 pl-10">
        </div>
        <button type="submit"
                class="inline-flex items-center gap-2 rounded-2xl bg-rose-600 px-5 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-rose-700 active:scale-95">
            Cari
        </button>
        @if(request('search'))
        <a href="{{ route('admin.products') }}" class="btn-secondary py-2.5 px-4 text-sm">Reset</a>
        @endif
    </form>
</div>

{{-- Table --}}
<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th class="pl-5 w-16">Foto</th>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Penjual</th>
                    <th>Lokasi</th>
                    <th>Status</th>
                    <th class="pr-5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                @php $photo = $product->photos->first(); @endphp
                <tr>
                    <td class="pl-5">
                        <div class="h-12 w-12 overflow-hidden rounded-xl bg-slate-100">
                            @if($photo && $photo->photo_url)
                                <img src="{{ $photo->photo_url }}"
                                     alt="{{ $product->title }}"
                                     class="h-full w-full object-cover"
                                     onerror="this.style.display='none'">
                            @endif
                        </div>
                    </td>
                    <td class="max-w-[220px]">
                        <a href="{{ route('products.show', $product) }}" target="_blank"
                           class="line-clamp-2 text-sm font-semibold text-brand-700 hover:text-brand-900 transition-colors">
                            {{ $product->title }}
                        </a>
                        @if($product->category)
                        <span class="mt-1 inline-block rounded-lg bg-slate-100 px-1.5 py-0.5 text-[10px] font-semibold uppercase text-slate-500">
                            {{ $product->category->name }}
                        </span>
                        @endif
                    </td>
                    <td class="whitespace-nowrap text-sm font-semibold text-slate-700">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </td>
                    <td>
                        <div class="flex items-center gap-2">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($product->user->name) }}&background=4f46e5&color=fff&size=32"
                                 class="h-7 w-7 flex-shrink-0 rounded-full">
                            <span class="text-sm text-slate-700">{{ $product->user->name }}</span>
                        </div>
                    </td>
                    <td class="text-sm text-slate-500">{{ $product->location }}</td>
                    <td>
                        <span class="badge {{ $product->is_sold ? 'badge-rose' : 'badge-emerald' }}">
                            {{ $product->is_sold ? 'Terjual' : 'Tersedia' }}
                        </span>
                    </td>
                    <td class="pr-5 text-right">
                        <form action="{{ route('admin.products.delete', $product) }}" method="POST"
                              onsubmit="return confirm('Hapus produk ini secara permanen?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="inline-flex items-center gap-1.5 rounded-xl border border-rose-200 bg-rose-50 px-3 py-1.5 text-xs font-semibold text-rose-600 transition-colors hover:bg-rose-100 active:scale-95">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-16 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100">
                                <svg class="h-6 w-6 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                            <p class="text-sm font-semibold text-slate-500">
                                {{ request('search') ? 'Produk tidak ditemukan' : 'Belum ada produk' }}
                            </p>
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
