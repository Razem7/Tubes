@extends('layouts.app')

@section('title', 'GadgetHub - ' . $product->title)

@section('content')
<div class="mx-auto max-w-6xl px-4 py-6">

    @php
        $conditionMap    = ['new' => 'Baru', 'like_new' => 'Seperti Baru', 'good' => 'Baik', 'fair' => 'Cukup Baik'];
        $conditionColors = [
            'new'      => 'background:#dcfce7;color:#15803d;',
            'like_new' => 'background:#dbeafe;color:#1d4ed8;',
            'good'     => 'background:#fef9c3;color:#a16207;',
            'fair'     => 'background:#ffedd5;color:#c2410c;',
        ];
        $firstPhoto = $product->photos->first();
    @endphp

    <nav class="mb-4 flex flex-wrap items-center gap-1.5 text-xs text-slate-400">
        <a href="{{ route('products.index') }}" class="hover:text-blue-600">Beranda</a>
        <span>/</span>
        @if($product->category)
        <a href="{{ route('products.index', ['category_id' => $product->category->id]) }}" class="hover:text-blue-600">{{ $product->category->name }}</a>
        <span>/</span>
        @endif
        <span class="max-w-xs truncate text-slate-600">{{ $product->title }}</span>
    </nav>

    <div class="grid items-start gap-6 md:grid-cols-2">
        <div>
            <div class="panel relative flex aspect-[4/3] items-center justify-center overflow-hidden">
                @if($firstPhoto && $firstPhoto->photo_url)
                    <img id="mainImage" src="{{ asset($firstPhoto->photo_url) }}" alt="{{ $product->title }}" class="h-full w-full object-contain bg-slate-50" onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                    <div class="hidden h-full w-full flex-col items-center justify-center text-slate-300" style="display:none;">
                        <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="mt-2 text-sm text-slate-400">Belum ada foto</span>
                    </div>
                @else
                    <div class="flex h-full w-full flex-col items-center justify-center text-slate-300">
                        <svg class="h-14 w-14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="mt-2 text-sm text-slate-400">Belum ada foto</span>
                    </div>
                @endif

                @if($product->is_sold)
                <div class="absolute inset-0 flex items-center justify-center bg-black/45">
                    <span class="rounded-full bg-red-600 px-4 py-1 text-sm font-bold tracking-wide text-white">TERJUAL</span>
                </div>
                @endif
            </div>

            @if($product->photos->count() > 1)
            <div class="mt-3 flex gap-2 overflow-x-auto pb-1">
                @foreach($product->photos as $i => $photo)
                @if($photo->photo_url)
                <img src="{{ asset($photo->photo_url) }}" alt="{{ $product->title }}" onclick="changeMainImage('{{ asset($photo->photo_url) }}', this)" class="h-16 w-16 flex-shrink-0 cursor-pointer rounded-2xl border-2 object-cover transition {{ $i===0 ? 'border-blue-500' : 'border-slate-200' }}">
                @endif
                @endforeach
            </div>
            @endif

            <div class="mt-4 hidden rounded-[24px] border border-slate-200 bg-white/90 p-5 shadow-sm md:block">
                <p class="mb-3 text-sm font-semibold text-slate-900">Deskripsi</p>
                <p class="whitespace-pre-line text-sm leading-relaxed text-slate-600">{{ $product->description }}</p>
            </div>
        </div>

        <div class="flex flex-col gap-4">
            <div class="panel p-5 md:p-6">
                <p class="text-3xl font-bold text-blue-600">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                <p class="mt-1 text-base font-semibold text-slate-800">{{ $product->title }}</p>

                <div class="mt-3 flex flex-wrap gap-2">
                    @if($product->category)
                    <span class="rounded-full border border-blue-200 bg-blue-50 px-3 py-1 text-[11px] font-semibold text-blue-700">{{ $product->category->name }}</span>
                    @endif
                    <span class="rounded-full px-3 py-1 text-[11px] font-semibold {{ $conditionColors[$product->condition] ?? 'background:#f3f4f6;color:#6b7280;' }}">{{ $conditionMap[$product->condition] ?? $product->condition }}</span>
                    <span class="inline-flex items-center gap-1 rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-[11px] font-medium text-slate-600">
                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                        {{ $product->location }}
                    </span>
                </div>

                <hr class="my-4 border-slate-200">

                @if($product->is_sold)
                <div class="rounded-2xl border border-rose-200 bg-rose-50 p-3 text-center text-sm font-semibold text-rose-600">Produk ini sudah terjual</div>
                @else
                <div class="flex flex-col gap-2">
                    @auth
                        @if($product->user_id === auth()->id())
                        <a href="{{ route('products.edit', $product) }}" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-blue-600 to-sky-500 px-4 py-2.5 text-sm font-semibold text-white transition hover:opacity-90">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Edit Produk
                        </a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-2xl border border-rose-200 bg-white px-4 py-2.5 text-sm font-medium text-rose-600 transition hover:bg-rose-50">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                Hapus Produk
                            </button>
                        </form>
                        @else
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('products.checkout', $product) }}" class="inline-flex items-center gap-2 rounded-2xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-700">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                Beli Sekarang
                            </a>
                            <form action="{{ route('chats.start', $product) }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-2 rounded-2xl border border-blue-200 bg-white px-4 py-2.5 text-sm font-semibold text-blue-700 transition hover:bg-blue-50">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                    Chat Penjual
                                </button>
                            </form>
                        </div>
                        <form action="{{ route('favorites.toggle', $product) }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-50">
                                @if($isFavorited)
                                <svg class="h-4 w-4 text-rose-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/></svg>
                                Hapus Favorit
                                @else
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                Tambah Favorit
                                @endif
                            </button>
                        </form>
                        @endif
                    @else
                        <div class="flex flex-wrap gap-2">
                            <button onclick="showLoginModal('Login untuk membeli produk ini.')" class="inline-flex items-center gap-2 rounded-2xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-700">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                Beli Sekarang
                            </button>
                            <button onclick="showLoginModal('Login untuk chat dengan penjual.')" class="inline-flex items-center gap-2 rounded-2xl border border-blue-200 bg-white px-4 py-2.5 text-sm font-semibold text-blue-700 transition hover:bg-blue-50">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                Chat Penjual
                            </button>
                        </div>
                        <button onclick="showLoginModal('Login untuk menyimpan ke favorit.')" class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-50">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                            Tambah Favorit
                        </button>
                    @endauth
                </div>
                @endif
            </div>

            <div class="panel p-4">
                <p class="mb-3 text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-400">Penjual</p>
                <div class="flex items-center gap-3">
                    @if($product->user->profile_photo_url)
                        <img src="{{ asset('storage/' . $product->user->profile_photo_url) }}" alt="{{ $product->user->name }}" class="h-11 w-11 flex-shrink-0 rounded-full border border-slate-200 object-cover">
                    @else
                        <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-blue-600 to-sky-500 text-sm font-bold text-white">
                            {{ strtoupper(substr($product->user->name, 0, 1)) }}
                        </div>
                    @endif
                    <div class="min-w-0">
                        <p class="truncate font-semibold text-slate-800">{{ $product->user->name }}</p>
                        @if($product->user->phone_verified)
                        <p class="mt-1 flex items-center gap-1 text-xs text-emerald-600">
                            <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            Terverifikasi
                        </p>
                        @else
                        <p class="mt-1 text-xs text-slate-400">Member GadgetHub</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="panel p-5">
                <p class="mb-3 text-sm font-semibold text-slate-900">Detail Produk</p>
                <div class="text-sm">
                    <div class="flex items-center justify-between border-b border-slate-100 py-2">
                        <span class="text-slate-500">Kondisi</span>
                        <span class="rounded-full px-2.5 py-1 text-[11px] font-semibold {{ $conditionColors[$product->condition] ?? 'background:#f3f4f6;color:#6b7280;' }}">{{ $conditionMap[$product->condition] ?? $product->condition }}</span>
                    </div>
                    @if($product->brand)
                    <div class="flex items-center justify-between border-b border-slate-100 py-2">
                        <span class="text-slate-500">Brand</span>
                        <span class="font-semibold text-slate-800">{{ $product->brand }}</span>
                    </div>
                    @endif
                    @if($product->model)
                    <div class="flex items-center justify-between border-b border-slate-100 py-2">
                        <span class="text-slate-500">Model</span>
                        <span class="font-semibold text-slate-800">{{ $product->model }}</span>
                    </div>
                    @endif
                    @if($product->category)
                    <div class="flex items-center justify-between border-b border-slate-100 py-2">
                        <span class="text-slate-500">Kategori</span>
                        <span class="font-semibold text-slate-800">{{ $product->category->name }}</span>
                    </div>
                    @endif
                    <div class="flex items-center justify-between py-2">
                        <span class="text-slate-500">Lokasi</span>
                        <span class="font-semibold text-slate-800">{{ $product->location }}</span>
                    </div>
                </div>
            </div>

            <div class="rounded-[24px] border border-amber-200 bg-amber-50 p-5">
                <p class="mb-2 flex items-center gap-2 text-xs font-bold uppercase tracking-[0.2em] text-amber-700">
                    <svg class="h-4 w-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    Tips Keamanan
                </p>
                <ul class="space-y-1 text-sm text-amber-700">
                    <li>• Gunakan rekber untuk keamanan transaksi</li>
                    <li>• Periksa kondisi barang sebelum membayar</li>
                    <li>• Jangan transfer ke rekening tidak dikenal</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="mt-4 rounded-[24px] border border-slate-200 bg-white/90 p-5 shadow-sm md:hidden">
        <p class="mb-3 text-sm font-semibold text-slate-900">Deskripsi</p>
        <p class="whitespace-pre-line text-sm leading-relaxed text-slate-600">{{ $product->description }}</p>
    </div>
</div>

@push('scripts')
<script>
function changeMainImage(src, thumb) {
    if (!src) return;
    var main = document.getElementById('mainImage');
    if (main) main.src = src;
    document.querySelectorAll('[onclick^="changeMainImage"]').forEach(function(el) {
        el.style.borderColor = '#e5e7eb';
    });
    if (thumb) thumb.style.borderColor = '#3b82f6';
}
</script>
@endpush

@endsection
