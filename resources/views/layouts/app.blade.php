<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'GadgetHub — Marketplace Gadget Bekas Terpercaya')</title>
    <meta name="description" content="@yield('description', 'Beli dan jual gadget bekas berkualitas di GadgetHub. Transaksi aman, penjual terverifikasi.')">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="alternate icon" href="/favicon.ico">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="flex min-h-screen flex-col bg-surface-50 text-slate-800 antialiased">

{{-- ══════════════════════════════════════════════════════
     NAVBAR
══════════════════════════════════════════════════════ --}}
<header id="site-header" class="sticky top-0 z-50 border-b border-slate-200/60 bg-white/80 backdrop-blur-xl transition-shadow duration-300">
    <div class="page-container">
        <div class="flex h-16 items-center gap-4">

            {{-- Logo --}}
            <a href="{{ route('products.index') }}"
               class="flex flex-shrink-0 items-center gap-2.5 transition-opacity hover:opacity-80 active:scale-95">
                <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-2xl bg-brand-gradient shadow-btn">
                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span class="text-xl font-extrabold tracking-tight text-brand-950">
                    Gadget<span class="text-brand-gradient">Hub</span>
                </span>
            </a>

            {{-- Desktop Search --}}
            <form action="{{ route('products.index') }}" method="GET"
                  class="hidden flex-1 max-w-xl md:block">
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-slate-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari gadget bekas impianmu…"
                           class="w-full rounded-2xl border border-slate-200 bg-slate-100/60 py-2.5 pl-11 pr-28
                                  text-sm text-slate-700 placeholder-slate-400 outline-none
                                  transition-all duration-250 ease-spring
                                  focus:border-brand-400 focus:bg-white focus:shadow-input-focus">
                    <button type="submit"
                            class="absolute inset-y-1.5 right-1.5 rounded-xl bg-brand-gradient px-4
                                   text-xs font-bold text-white shadow-sm transition-opacity hover:opacity-90">
                        Cari
                    </button>
                </div>
            </form>

            {{-- Desktop Nav Actions --}}
            <div class="hidden items-center gap-3 md:flex">
                @auth
                    @if(!auth()->user()->is_admin)
                        {{-- Chat --}}
                        <a href="{{ route('chats.index') }}"
                           class="btn-icon relative" title="Pesan">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            <span id="navbar-chat-dot" style="display:none;"
                                  class="absolute right-2 top-2 h-2.5 w-2.5 rounded-full bg-rose-500 ring-2 ring-white"></span>
                        </a>

                        {{-- Post Ad --}}
                        <a href="{{ route('products.create') }}" class="btn-primary py-2 px-4 text-xs">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            Pasang Iklan
                        </a>
                    @endif

                    {{-- Profile Dropdown --}}
                    <div class="relative" id="profile-dropdown-wrap">
                        <button type="button" id="profile-toggle"
                                class="flex items-center gap-2 rounded-2xl border border-slate-200 bg-white
                                       py-1.5 pl-1.5 pr-3 transition-all hover:border-slate-300 hover:bg-slate-50">
                            <div class="relative">
                                <img src="{{ auth()->user()->profile_photo_url
                                    ? asset('storage/'.auth()->user()->profile_photo_url)
                                    : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=4f46e5&color=fff' }}"
                                     alt="Foto profil" class="avatar avatar-sm">
                                <span id="profile-dot" style="display:none;"
                                      class="absolute -right-0.5 -top-0.5 h-2.5 w-2.5 rounded-full bg-rose-500 ring-2 ring-white"></span>
                            </div>
                            <span class="max-w-[88px] truncate text-xs font-semibold text-slate-700">
                                {{ auth()->user()->name }}
                            </span>
                            <svg class="h-3.5 w-3.5 flex-shrink-0 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        {{-- Dropdown Panel --}}
                        <div id="profile-dropdown"
                             class="absolute right-0 top-full mt-2 hidden w-56 animate-slide-down
                                    rounded-3xl border border-slate-200/70 bg-white p-2 shadow-modal z-50">
                            @include('layouts.partials.nav-dropdown')
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn-ghost text-sm">Masuk</a>
                    <a href="{{ route('register') }}" class="btn-primary py-2 px-5 text-sm">Daftar</a>
                    <a href="{{ route('products.create') }}" class="btn-secondary py-2 px-4 text-sm">
                        + Pasang Iklan
                    </a>
                @endauth
            </div>

            {{-- Mobile Controls --}}
            <div class="flex items-center gap-2 md:hidden ml-auto">
                <button type="button" id="mobile-search-toggle"
                        class="btn-icon" aria-label="Cari">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/>
                    </svg>
                </button>
                <button type="button" id="mobile-menu-toggle"
                        class="btn-icon" aria-label="Menu">
                    <svg class="h-5 w-5" id="menu-icon-open" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>

        </div>{{-- /flex h-16 --}}

        {{-- Mobile Search (hidden by default) --}}
        <div id="mobile-search-bar" class="hidden pb-3 pt-1">
            <form action="{{ route('products.index') }}" method="GET" class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-slate-400">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/>
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari gadget bekas…"
                       class="w-full rounded-2xl border border-slate-200 bg-slate-100/70 py-3 pl-11 pr-4
                              text-sm outline-none focus:border-brand-400 focus:bg-white focus:shadow-input-focus">
            </form>
        </div>

    </div>{{-- /page-container --}}

    {{-- Mobile Menu --}}
    <div id="mobile-menu" class="hidden border-t border-slate-100 bg-white md:hidden">
        @include('layouts.partials.nav-mobile')
    </div>
</header>

{{-- ══════════════════════════════════════════════════════
     FLASH MESSAGES
══════════════════════════════════════════════════════ --}}
@if(session('success') || session('error') || session('warning') || session('info'))
<div class="page-container pt-5">
    @if(session('success'))
    <div class="alert alert-success">
        <div class="alert-icon bg-emerald-500 shadow-emerald-500/25">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <p class="font-semibold">{{ session('success') }}</p>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-error">
        <div class="alert-icon bg-rose-500 shadow-rose-500/25">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        <p class="font-semibold">{{ session('error') }}</p>
    </div>
    @endif
    @if(session('warning'))
    <div class="alert alert-warning">
        <div class="alert-icon bg-amber-500 shadow-amber-500/25">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01"/>
            </svg>
        </div>
        <p class="font-semibold">{{ session('warning') }}</p>
    </div>
    @endif
    @if(session('info'))
    <div class="alert alert-info">
        <div class="alert-icon bg-brand-500 shadow-brand-500/25">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01"/>
            </svg>
        </div>
        <p class="font-semibold">{{ session('info') }}</p>
    </div>
    @endif
</div>
@endif

{{-- ══════════════════════════════════════════════════════
     MAIN CONTENT
══════════════════════════════════════════════════════ --}}
<main class="flex-1 pb-16 pt-6">
    @yield('content')
</main>

{{-- ══════════════════════════════════════════════════════
     FOOTER
══════════════════════════════════════════════════════ --}}
<footer class="border-t border-slate-200/60 bg-white">
    <div class="page-container py-12">
        <div class="grid grid-cols-1 gap-10 md:grid-cols-12">

            {{-- Brand Column --}}
            <div class="md:col-span-5 space-y-4">
                <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2.5">
                    <div class="flex h-9 w-9 items-center justify-center rounded-2xl bg-brand-gradient shadow-btn">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <span class="text-xl font-extrabold tracking-tight text-brand-950">
                        Gadget<span class="text-brand-gradient">Hub</span>
                    </span>
                </a>
                <p class="text-sm text-slate-500 leading-relaxed max-w-sm">
                    Platform jual beli gadget bekas paling terpercaya di Indonesia. Menghubungkan pembeli dan penjual dengan transaksi aman, praktis, dan terverifikasi.
                </p>
                <div class="flex gap-3 pt-1">
                    <a href="#" aria-label="Instagram"
                       class="flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-500 hover:border-brand-300 hover:text-brand-600 transition-colors">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                    <a href="#" aria-label="Twitter / X"
                       class="flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-500 hover:border-brand-300 hover:text-brand-600 transition-colors">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                    <a href="#" aria-label="WhatsApp"
                       class="flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-500 hover:border-brand-300 hover:text-brand-600 transition-colors">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    </a>
                </div>
            </div>

            {{-- Marketplace Links --}}
            <div class="md:col-span-2">
                <h5 class="mb-4 text-xs font-extrabold uppercase tracking-widest text-slate-900">Marketplace</h5>
                <ul class="space-y-2.5 text-sm text-slate-500">
                    <li><a href="{{ route('products.index') }}" class="hover:text-brand-600 transition-colors">Semua Gadget</a></li>
                    <li><a href="{{ route('products.create') }}" class="hover:text-brand-600 transition-colors">Jual Gadget</a></li>
                    <li><a href="{{ route('favorites.index') }}" class="hover:text-brand-600 transition-colors">Favorit Saya</a></li>
                </ul>
            </div>

            {{-- Account Links --}}
            <div class="md:col-span-2">
                <h5 class="mb-4 text-xs font-extrabold uppercase tracking-widest text-slate-900">Akun</h5>
                <ul class="space-y-2.5 text-sm text-slate-500">
                    <li><a href="{{ route('login') }}" class="hover:text-brand-600 transition-colors">Masuk</a></li>
                    <li><a href="{{ route('register') }}" class="hover:text-brand-600 transition-colors">Daftar Gratis</a></li>
                    <li><a href="{{ route('profile.show') }}" class="hover:text-brand-600 transition-colors">Profil Saya</a></li>
                </ul>
            </div>

            {{-- Contact --}}
            <div class="md:col-span-3">
                <h5 class="mb-4 text-xs font-extrabold uppercase tracking-widest text-slate-900">Kontak</h5>
                <ul class="space-y-2.5 text-sm text-slate-500">
                    <li class="flex items-center gap-2">
                        <svg class="h-4 w-4 text-brand-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        support@gadgethub.id
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="h-4 w-4 text-brand-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        +62 812-3456-7890
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="h-4 w-4 text-brand-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Jakarta, Indonesia
                    </li>
                </ul>
            </div>
        </div>

        {{-- Bottom Bar --}}
        <div class="mt-10 flex flex-col items-center justify-between gap-4 border-t border-slate-100 pt-6 text-xs text-slate-400 sm:flex-row">
            <p>&copy; {{ date('Y') }} GadgetHub. Hak cipta dilindungi.</p>
            <div class="flex items-center gap-5">
                <a href="#" class="hover:text-slate-600 transition-colors">Syarat &amp; Ketentuan</a>
                <a href="#" class="hover:text-slate-600 transition-colors">Kebijakan Privasi</a>
                <a href="#" class="hover:text-slate-600 transition-colors">Pusat Bantuan</a>
            </div>
        </div>
    </div>
</footer>

{{-- ══════════════════════════════════════════════════════
     LOGIN REQUIRED MODAL
══════════════════════════════════════════════════════ --}}
<div id="loginModal" style="display:none;"
     class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/60 p-4 backdrop-blur-sm">
    <div class="relative w-full max-w-sm animate-scale-in rounded-4xl border border-slate-200/60 bg-white p-8 shadow-modal">
        <button onclick="closeLoginModal()"
                class="absolute right-4 top-4 flex h-8 w-8 items-center justify-center rounded-xl
                       text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition-colors"
                aria-label="Tutup">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        <div class="mb-6 text-center">
            <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-50">
                <svg class="h-7 w-7 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-900">Login Diperlukan</h3>
            <p id="loginModalMessage" class="mt-1.5 text-sm text-slate-500 leading-relaxed">
                Silakan login untuk melanjutkan.
            </p>
        </div>
        <div class="flex flex-col gap-2.5">
            <a href="{{ route('login') }}" class="btn-primary w-full py-3 text-sm font-bold">
                Masuk Sekarang
            </a>
            <a href="{{ route('register') }}" class="btn-secondary w-full py-3 text-sm">
                Belum punya akun? Daftar gratis
            </a>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════
     SCRIPTS
══════════════════════════════════════════════════════ --}}
<script>
(function () {
    // ── Navbar scroll shadow ──────────────────────────────
    const header = document.getElementById('site-header');
    window.addEventListener('scroll', function () {
        header.classList.toggle('shadow-md', window.scrollY > 8);
    }, { passive: true });

    // ── Profile dropdown ──────────────────────────────────
    const toggle = document.getElementById('profile-toggle');
    const dropdown = document.getElementById('profile-dropdown');
    if (toggle && dropdown) {
        toggle.addEventListener('click', function (e) {
            e.stopPropagation();
            dropdown.classList.toggle('hidden');
        });
        document.addEventListener('click', function (e) {
            if (!document.getElementById('profile-dropdown-wrap')?.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
    }

    // ── Mobile menu ───────────────────────────────────────
    const menuToggle  = document.getElementById('mobile-menu-toggle');
    const mobileMenu  = document.getElementById('mobile-menu');
    const searchToggle = document.getElementById('mobile-search-toggle');
    const searchBar   = document.getElementById('mobile-search-bar');

    if (menuToggle && mobileMenu) {
        menuToggle.addEventListener('click', function () {
            const open = mobileMenu.classList.toggle('hidden') === false;
            if (open && searchBar) searchBar.classList.add('hidden');
        });
    }
    if (searchToggle && searchBar) {
        searchToggle.addEventListener('click', function () {
            const open = searchBar.classList.toggle('hidden') === false;
            if (open) {
                if (mobileMenu) mobileMenu.classList.add('hidden');
                searchBar.querySelector('input')?.focus();
            }
        });
    }

    // ── Login Modal ───────────────────────────────────────
    window.showLoginModal = function (message) {
        var modal = document.getElementById('loginModal');
        var msg = document.getElementById('loginModalMessage');
        if (!modal) return;
        if (msg && message) msg.textContent = message;
        modal.style.display = 'flex';
    };
    window.closeLoginModal = function () {
        var modal = document.getElementById('loginModal');
        if (modal) modal.style.display = 'none';
    };
    var loginModal = document.getElementById('loginModal');
    if (loginModal) {
        loginModal.addEventListener('click', function (e) {
            if (e.target === this) window.closeLoginModal();
        });
    }

    // Legacy alias
    window.toggleDropdown = function () {
        if (dropdown) dropdown.classList.toggle('hidden');
    };
    window.toggleMobileMenu = function () {
        if (mobileMenu) mobileMenu.classList.toggle('hidden');
    };
    window.toggleMobileSearch = function () {
        if (searchBar) searchBar.classList.toggle('hidden');
    };
})();

@auth
const UNREAD_CHATS_URL = '{{ route("notifications.unread-chats") }}';
const UNREAD_TRX_URL   = '{{ route("notifications.unread-transactions") }}';
const NOTIF_READ_ALL   = '{{ route("notifications.read-all") }}';
const CSRF             = document.querySelector('meta[name="csrf-token"]').content;

function updateAllDots() {
    Promise.all([
        fetch(UNREAD_CHATS_URL, { credentials: 'same-origin', headers: { 'X-Requested-With': 'XMLHttpRequest' } }).then(r => r.ok ? r.json() : null),
        fetch(UNREAD_TRX_URL,   { credentials: 'same-origin', headers: { 'X-Requested-With': 'XMLHttpRequest' } }).then(r => r.ok ? r.json() : null),
    ]).then(([chatData, trxData]) => {
        const chatCount = chatData?.count ?? 0;
        const trxCount  = trxData?.count  ?? 0;
        const el = (id) => document.getElementById(id);
        const show = (id, show) => { const e = el(id); if (e) e.style.display = show ? 'block' : 'none'; };
        const showInline = (id, show) => { const e = el(id); if (e) e.style.display = show ? 'inline-block' : 'none'; };
        show('navbar-chat-dot', chatCount > 0);
        showInline('transaction-dot', trxCount > 0);
        show('profile-dot', chatCount > 0 || trxCount > 0);
    }).catch(() => {});
}

function markAsRead(id) {
    fetch(`/notifications/${id}/read`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': CSRF, 'X-Requested-With': 'XMLHttpRequest' },
    }).then(() => updateAllDots()).catch(() => {});
}
function markAllRead() {
    fetch(NOTIF_READ_ALL, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': CSRF, 'X-Requested-With': 'XMLHttpRequest' },
    }).then(() => updateAllDots()).catch(() => {});
}

updateAllDots();
setInterval(updateAllDots, 15000);
@endauth
</script>

@stack('scripts')
</body>
</html>
