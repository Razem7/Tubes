@extends('layouts.merchant')
@section('title', 'Dashboard — Merchant GadgetHub')

@section('content')

{{-- ── Page Header ── --}}
<div class="mb-8 flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <p class="section-eyebrow">Merchant Panel</p>
        <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">
            Halo, {{ auth()->user()->name }} 👋
        </h1>
        <p class="mt-0.5 text-sm text-slate-500">Selamat datang kembali. Ini ringkasan tokomu hari ini.</p>
    </div>
    <a href="{{ route('merchant.products.create') }}" class="btn-merchant mt-4 self-start sm:mt-0">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Produk
    </a>
</div>

{{-- ── Stats Grid ── --}}
<div class="mb-8 grid grid-cols-2 gap-4 lg:grid-cols-4">
    {{-- Total Produk --}}
    <div class="card p-5">
        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-2xl bg-purple-50">
            <svg class="h-5 w-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3z"/>
            </svg>
        </div>
        <p class="stat-number">{{ $stats['total_products'] }}</p>
        <p class="stat-label">Total Produk</p>
    </div>

    {{-- Produk Aktif --}}
    <div class="card p-5">
        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-2xl bg-emerald-50">
            <svg class="h-5 w-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <p class="stat-number text-emerald-600">{{ $stats['total_active'] }}</p>
        <p class="stat-label">Produk Aktif</p>
    </div>

    {{-- Terjual --}}
    <div class="card p-5">
        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-2xl bg-amber-50">
            <svg class="h-5 w-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
        </div>
        <p class="stat-number text-amber-600">{{ $stats['total_sold'] }}</p>
        <p class="stat-label">Terjual</p>
    </div>

    {{-- Revenue --}}
    <div class="card p-5">
        <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-2xl bg-brand-50">
            <svg class="h-5 w-5 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <p class="text-lg font-extrabold text-slate-900">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
        <p class="stat-label">Total Revenue</p>
    </div>
</div>

{{-- ── Two-column panels ── --}}
<div class="mb-6 grid grid-cols-1 gap-6 lg:grid-cols-2">

    {{-- Produk Terbaru --}}
    <div class="card">
        <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
            <h3 class="font-bold text-slate-800">Produk Terbaru</h3>
            <a href="{{ route('merchant.products') }}" class="text-xs font-semibold text-purple-600 hover:text-purple-800 transition-colors">
                Lihat semua →
            </a>
        </div>
        <div class="divide-y divide-slate-50">
            @forelse($recent_products as $product)
            @php $photo = $product->photos->first(); @endphp
            <div class="flex items-center gap-3 px-5 py-3.5 transition-colors hover:bg-slate-50/60">
                <div class="h-11 w-11 flex-shrink-0 overflow-hidden rounded-xl bg-slate-100">
                    @if($photo && $photo->photo_url)
                        <img src="{{ $photo->photo_url }}" class="h-full w-full object-cover"
                             onerror="this.style.display='none'">
                    @endif
                </div>
                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-semibold text-slate-800">{{ $product->title }}</p>
                    <p class="text-xs text-slate-400">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                </div>
                <span class="badge {{ $product->is_sold ? 'badge-rose' : 'badge-emerald' }} flex-shrink-0">
                    {{ $product->is_sold ? 'Terjual' : 'Aktif' }}
                </span>
            </div>
            @empty
            <div class="px-5 py-8 text-center">
                <p class="text-sm text-slate-400">Belum ada produk.</p>
                <a href="{{ route('merchant.products.create') }}" class="mt-2 inline-block text-xs font-semibold text-purple-600 hover:underline">
                    Tambah sekarang
                </a>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Penjualan Terbaru --}}
    <div class="card">
        <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
            <h3 class="font-bold text-slate-800">Penjualan Terbaru</h3>
            <a href="{{ route('merchant.sales') }}" class="text-xs font-semibold text-purple-600 hover:text-purple-800 transition-colors">
                Lihat semua →
            </a>
        </div>
        <div class="divide-y divide-slate-50">
            @forelse($recent_sales as $sale)
            @php
                $photo = $sale->product->photos->first();
                [$statusLabel, $statusClass] = $sale->statusBadge();
            @endphp
            <div class="flex items-center gap-3 px-5 py-3.5 transition-colors hover:bg-slate-50/60">
                <div class="h-11 w-11 flex-shrink-0 overflow-hidden rounded-xl bg-slate-100">
                    @if($photo && $photo->photo_url)
                        <img src="{{ $photo->photo_url }}" class="h-full w-full object-cover"
                             onerror="this.style.display='none'">
                    @endif
                </div>
                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-semibold text-slate-800">{{ Str::limit($sale->product->title, 35) }}</p>
                    <p class="text-xs text-slate-400">oleh {{ $sale->buyer->name }}</p>
                </div>
                <div class="flex-shrink-0 text-right">
                    <p class="text-sm font-bold text-emerald-600">Rp {{ number_format($sale->amount, 0, ',', '.') }}</p>
                    <span class="badge {{ $statusClass }} text-[10px]">{{ $statusLabel }}</span>
                </div>
            </div>
            @empty
            <div class="px-5 py-8 text-center">
                <p class="text-sm text-slate-400">Belum ada penjualan.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

{{-- ── Chat Masuk ── --}}
<div class="card mb-6">
    <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
        <div class="flex items-center gap-2.5">
            <h3 class="font-bold text-slate-800">Chat Masuk</h3>
            @if($unread_chats > 0)
            <span class="badge badge-rose">{{ $unread_chats }} belum dibaca</span>
            @endif
        </div>
        <a href="{{ route('chats.index') }}" class="text-xs font-semibold text-purple-600 hover:text-purple-800 transition-colors">
            Lihat semua →
        </a>
    </div>
    <div class="divide-y divide-slate-50">
        @forelse($recent_chats as $chat)
        @php
            $hasUnread = $chat->messages->where('sender_id', '!=', auth()->id())->whereNull('read_at')->count() > 0;
        @endphp
        <a href="{{ route('chats.show', $chat) }}"
           class="flex items-center gap-3 px-5 py-3.5 transition-colors hover:bg-slate-50/60
                  {{ $hasUnread ? 'bg-purple-50/40' : '' }}">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($chat->buyer->name) }}&background=7c3aed&color=fff"
                 class="avatar avatar-sm flex-shrink-0">
            <div class="min-w-0 flex-1">
                <div class="flex items-center justify-between gap-2">
                    <p class="truncate text-sm font-semibold text-slate-800">{{ $chat->buyer->name }}</p>
                    <span class="flex-shrink-0 text-[11px] text-slate-400">{{ $chat->updated_at->diffForHumans() }}</span>
                </div>
                <p class="truncate text-xs text-slate-500">re: {{ $chat->product->title ?? 'Produk dihapus' }}</p>
                @if($chat->latestMessage)
                <p class="truncate text-xs {{ $hasUnread ? 'font-semibold text-purple-700' : 'text-slate-400' }}">
                    {{ $chat->latestMessage->message_text }}
                </p>
                @endif
            </div>
            @if($hasUnread)
            <span class="h-2.5 w-2.5 flex-shrink-0 rounded-full bg-rose-500"></span>
            @endif
        </a>
        @empty
        <div class="px-5 py-8 text-center">
            <p class="text-sm text-slate-400">Belum ada chat masuk dari pembeli.</p>
        </div>
        @endforelse
    </div>
</div>

{{-- ── Quick Actions ── --}}
<div class="flex flex-wrap gap-3">
    <a href="{{ route('merchant.products.create') }}" class="btn-merchant">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Produk
    </a>
    <a href="{{ route('merchant.stock') }}" class="btn-secondary">
        <svg class="h-4 w-4 text-slate-500" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4z" clip-rule="evenodd"/>
        </svg>
        Kelola Stok
    </a>
    <a href="{{ route('merchant.sales') }}" class="btn-secondary">
        <svg class="h-4 w-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
        </svg>
        Lihat Penjualan
    </a>
</div>

@endsection
