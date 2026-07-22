@extends('layouts.admin')
@section('title', 'Dashboard — Super Admin GadgetHub')

@section('content')

{{-- Header --}}
<div class="mb-8 flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <p class="section-eyebrow text-rose-600">Super Admin</p>
        <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">
            Selamat datang, {{ auth()->user()->name }} 👋
        </h1>
        <p class="mt-0.5 text-sm text-slate-500">Ringkasan aktivitas platform GadgetHub hari ini.</p>
    </div>
    <a href="{{ route('products.index') }}" target="_blank"
       class="btn-secondary mt-4 self-start sm:mt-0 text-sm">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
        </svg>
        Lihat Website
    </a>
</div>

{{-- Stats Grid --}}
<div class="mb-8 grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-6">

    <div class="card p-5">
        <div class="mb-3 flex h-9 w-9 items-center justify-center rounded-xl bg-brand-50">
            <svg class="h-5 w-5 text-brand-600" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
            </svg>
        </div>
        <p class="stat-number text-brand-600">{{ $stats['total_users'] }}</p>
        <p class="stat-label">User Biasa</p>
    </div>

    <div class="card p-5">
        <div class="mb-3 flex h-9 w-9 items-center justify-center rounded-xl bg-purple-50">
            <svg class="h-5 w-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9z" clip-rule="evenodd"/>
            </svg>
        </div>
        <p class="stat-number text-purple-600">{{ $stats['total_merchants'] }}</p>
        <p class="stat-label">Merchant</p>
    </div>

    <div class="card p-5">
        <div class="mb-3 flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-50">
            <svg class="h-5 w-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3z"/>
            </svg>
        </div>
        <p class="stat-number text-emerald-600">{{ $stats['total_products'] }}</p>
        <p class="stat-label">Total Produk</p>
    </div>

    <div class="card p-5">
        <div class="mb-3 flex h-9 w-9 items-center justify-center rounded-xl bg-amber-50">
            <svg class="h-5 w-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
        </div>
        <p class="stat-number text-amber-600">{{ $stats['total_sold'] }}</p>
        <p class="stat-label">Terjual</p>
    </div>

    <div class="card p-5">
        <div class="mb-3 flex h-9 w-9 items-center justify-center rounded-xl bg-pink-50">
            <svg class="h-5 w-5 text-pink-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
        </div>
        <p class="stat-number text-pink-600">{{ $stats['total_chats'] }}</p>
        <p class="stat-label">Total Chat</p>
    </div>

    <div class="card p-5">
        <div class="mb-3 flex h-9 w-9 items-center justify-center rounded-xl bg-teal-50">
            <svg class="h-5 w-5 text-teal-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1"/>
            </svg>
        </div>
        <p class="text-sm font-extrabold text-slate-900 leading-tight">Rp&nbsp;{{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
        <p class="stat-label">Revenue</p>
    </div>

</div>

{{-- Two-column feed --}}
<div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

    {{-- Recent Products --}}
    <div class="card">
        <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
            <h3 class="font-bold text-slate-800">Produk Terbaru</h3>
            <a href="{{ route('admin.products') }}"
               class="text-xs font-semibold text-rose-600 hover:text-rose-800 transition-colors">Lihat semua →</a>
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
                    <p class="text-xs text-slate-400">{{ $product->user->name }} · Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                </div>
                <span class="badge {{ $product->is_sold ? 'badge-rose' : 'badge-emerald' }} flex-shrink-0">
                    {{ $product->is_sold ? 'Terjual' : 'Aktif' }}
                </span>
            </div>
            @empty
            <div class="px-5 py-8 text-center text-sm text-slate-400">Belum ada produk.</div>
            @endforelse
        </div>
    </div>

    {{-- Recent Users --}}
    <div class="card">
        <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
            <h3 class="font-bold text-slate-800">User Terbaru</h3>
            <a href="{{ route('admin.users') }}"
               class="text-xs font-semibold text-rose-600 hover:text-rose-800 transition-colors">Lihat semua →</a>
        </div>
        <div class="divide-y divide-slate-50">
            @forelse($recent_users as $user)
            <div class="flex items-center gap-3 px-5 py-3.5 transition-colors hover:bg-slate-50/60">
                <img src="{{ $user->profile_photo_url
                    ? asset('storage/'.$user->profile_photo_url)
                    : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=4f46e5&color=fff' }}"
                     class="avatar avatar-sm flex-shrink-0">
                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-semibold text-slate-800">{{ $user->name }}</p>
                    <p class="truncate text-xs text-slate-400">{{ $user->email }}</p>
                </div>
                <span class="badge {{ $user->isMerchant() ? 'badge-purple' : 'badge-indigo' }} flex-shrink-0">
                    {{ $user->isMerchant() ? 'Merchant' : 'User' }}
                </span>
            </div>
            @empty
            <div class="px-5 py-8 text-center text-sm text-slate-400">Belum ada user.</div>
            @endforelse
        </div>
    </div>

</div>

@endsection
