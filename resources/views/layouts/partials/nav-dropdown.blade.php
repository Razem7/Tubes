{{-- Profile Dropdown Menu (desktop) --}}
@auth
@if(!auth()->user()->isSuperAdmin())
    @if(auth()->user()->isMerchant())
    <a href="{{ route('merchant.dashboard') }}"
       class="flex items-center gap-2.5 rounded-2xl px-3 py-2.5 text-xs font-bold text-purple-700 hover:bg-purple-50 transition-colors">
        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
        </svg>
        Dashboard Merchant
    </a>
    <div class="my-1 border-t border-slate-100 mx-2"></div>
    @elseif(auth()->user()->isUser())
    <a href="{{ route('merchant.apply.create') }}"
       class="flex items-center gap-2.5 rounded-2xl px-3 py-2.5 text-xs font-bold text-brand-700 hover:bg-brand-50 transition-colors">
        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
            <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
            <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
        </svg>
        Daftar Jadi Merchant
    </a>
    <div class="my-1 border-t border-slate-100 mx-2"></div>
    <a href="{{ route('products.my') }}"
       class="flex items-center gap-2.5 rounded-2xl px-3 py-2 text-xs text-slate-700 hover:bg-slate-50 transition-colors">
        <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
        Produk Saya
    </a>
    @endif
    <a href="{{ route('favorites.index') }}"
       class="flex items-center gap-2.5 rounded-2xl px-3 py-2 text-xs text-slate-700 hover:bg-slate-50 transition-colors">
        <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
        </svg>
        Favorit
    </a>
    <a href="{{ route('transactions.index') }}"
       class="flex items-center justify-between rounded-2xl px-3 py-2 text-xs text-slate-700 hover:bg-slate-50 transition-colors">
        <span class="flex items-center gap-2.5">
            <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
            </svg>
            {{ auth()->user()->isMerchant() ? 'Pesanan Masuk' : 'Transaksi' }}
        </span>
        <span id="transaction-dot" style="display:none; width:8px; height:8px; background:#f43f5e; border-radius:50%; flex-shrink:0;"></span>
    </a>
    <div class="my-1 border-t border-slate-100 mx-2"></div>
@endif

<a href="{{ route('profile.show') }}"
   class="flex items-center gap-2.5 rounded-2xl px-3 py-2 text-xs text-slate-700 hover:bg-slate-50 transition-colors">
    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
    </svg>
    Profil Saya
</a>

@if(auth()->user()->isSuperAdmin())
<a href="{{ route('admin.dashboard') }}"
   class="flex items-center gap-2.5 rounded-2xl px-3 py-2.5 text-xs font-bold text-rose-600 hover:bg-rose-50 transition-colors">
    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
    </svg>
    Admin Dashboard
</a>
@endif

<div class="my-1 border-t border-slate-100 mx-2"></div>
<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit"
            class="flex w-full items-center gap-2.5 rounded-2xl px-3 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50 transition-colors">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h6a2 2 0 012 2v1"/>
        </svg>
        Keluar
    </button>
</form>
@endauth
