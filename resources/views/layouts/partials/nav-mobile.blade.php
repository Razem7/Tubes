{{-- Mobile Navigation Menu --}}
<div class="px-4 py-4 space-y-1">
@auth
    {{-- User Info --}}
    <div class="mb-4 flex items-center gap-3 rounded-2xl border border-slate-100 bg-slate-50 p-3">
        <img src="{{ auth()->user()->profile_photo_url
            ? asset('storage/'.auth()->user()->profile_photo_url)
            : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=4f46e5&color=fff' }}"
             alt="Foto profil" class="avatar avatar-md flex-shrink-0">
        <div class="min-w-0">
            <p class="truncate text-sm font-bold text-slate-800">{{ auth()->user()->name }}</p>
            <p class="truncate text-xs text-slate-400">{{ auth()->user()->email }}</p>
        </div>
    </div>

    @if(!auth()->user()->is_admin)
    <a href="{{ route('products.create') }}"
       class="flex items-center gap-3 rounded-2xl bg-brand-gradient px-4 py-3 text-sm font-bold text-white shadow-btn mb-3">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        Pasang Iklan
    </a>

    @if(auth()->user()->isMerchant())
    <a href="{{ route('merchant.dashboard') }}"
       class="flex items-center gap-3 rounded-2xl px-4 py-2.5 text-sm font-semibold text-purple-700 hover:bg-purple-50 transition-colors">
        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
        Dashboard Merchant
    </a>
    @endif

    <a href="{{ route('products.my') }}"
       class="flex items-center gap-3 rounded-2xl px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
        <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
        </svg>
        Produk Saya
    </a>
    <a href="{{ route('favorites.index') }}"
       class="flex items-center gap-3 rounded-2xl px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
        <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
        </svg>
        Favorit
    </a>
    <a href="{{ route('chats.index') }}"
       class="flex items-center gap-3 rounded-2xl px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
        <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
        </svg>
        Chat
    </a>
    <a href="{{ route('transactions.index') }}"
       class="flex items-center gap-3 rounded-2xl px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
        <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
        </svg>
        {{ auth()->user()->isMerchant() ? 'Pesanan Masuk' : 'Transaksi' }}
    </a>
    @else
    <a href="{{ route('admin.dashboard') }}"
       class="flex items-center gap-3 rounded-2xl px-4 py-2.5 text-sm font-semibold text-rose-600 hover:bg-rose-50 transition-colors">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
        Admin Dashboard
    </a>
    @endif

    <div class="my-2 border-t border-slate-100"></div>
    <a href="{{ route('profile.show') }}"
       class="flex items-center gap-3 rounded-2xl px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
        <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
        </svg>
        Profil Saya
    </a>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit"
                class="flex w-full items-center gap-3 rounded-2xl px-4 py-2.5 text-sm font-semibold text-rose-600 hover:bg-rose-50 transition-colors">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h6a2 2 0 012 2v1"/>
            </svg>
            Keluar
        </button>
    </form>

@else
    <a href="{{ route('register') }}"
       class="flex items-center justify-center rounded-2xl bg-brand-gradient py-3 text-sm font-bold text-white shadow-btn mb-2">
        Daftar Gratis
    </a>
    <a href="{{ route('login') }}"
       class="flex items-center justify-center rounded-2xl border border-brand-200 py-3 text-sm font-semibold text-brand-700 hover:bg-brand-50 transition-colors mb-2">
        Masuk
    </a>
    <a href="{{ route('products.create') }}"
       class="flex items-center justify-center rounded-2xl border border-slate-200 py-3 text-sm text-slate-600 hover:bg-slate-50 transition-colors">
        + Pasang Iklan
    </a>
@endauth
</div>
