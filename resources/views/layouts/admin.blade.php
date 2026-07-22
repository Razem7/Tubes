<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Super Admin — GadgetHub')</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="alternate icon" href="/favicon.ico">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 flex flex-col min-h-screen font-sans antialiased">

{{-- ── Admin Top Navbar ─────────────────────────────────────── --}}
<header class="sticky top-0 z-50 flex h-16 items-center border-b border-slate-200/70 bg-white/90 backdrop-blur-xl shadow-nav">
    <div class="flex w-full items-center justify-between px-6">

        {{-- Brand --}}
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5">
            <div class="flex h-8 w-8 items-center justify-center rounded-xl"
                 style="background: linear-gradient(135deg, #e11d48 0%, #dc2626 100%);">
                <svg class="h-4.5 w-4.5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="leading-tight">
                <span class="block text-sm font-extrabold tracking-tight text-slate-900">GadgetHub</span>
                <span class="block text-[10px] font-bold uppercase tracking-widest text-rose-600">Super Admin</span>
            </div>
        </a>

        {{-- Right side --}}
        <div class="flex items-center gap-4">
            <a href="{{ route('products.index') }}" target="_blank"
               class="hidden items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-600 hover:border-slate-300 hover:text-slate-800 transition-colors sm:flex">
                Lihat Website
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
            </a>
            <div class="relative" id="admin-profile-wrap">
                <button type="button" id="admin-profile-toggle"
                        class="flex items-center gap-2.5 rounded-2xl border border-slate-200 bg-white py-1.5 pl-1.5 pr-3 hover:bg-slate-50 transition-colors">
                    <img src="{{ auth()->user()->profile_photo_url
                        ? asset('storage/'.auth()->user()->profile_photo_url)
                        : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=dc2626&color=fff' }}"
                         alt="Profil" class="avatar avatar-sm">
                    <span class="text-xs font-semibold text-slate-700 hidden sm:block max-w-[100px] truncate">
                        {{ auth()->user()->name }}
                    </span>
                    <svg class="h-3.5 w-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div id="admin-dropdown"
                     class="absolute right-0 top-full mt-2 hidden w-48 animate-slide-down rounded-2xl border border-slate-200/70 bg-white p-2 shadow-modal z-50">
                    <a href="{{ route('profile.show') }}"
                       class="flex items-center gap-2.5 rounded-xl px-3 py-2 text-xs text-slate-700 hover:bg-slate-50 transition-colors">
                        <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Profil Saya
                    </a>
                    <div class="my-1 border-t border-slate-100 mx-1"></div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="flex w-full items-center gap-2.5 rounded-xl px-3 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50 transition-colors">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7"/>
                            </svg>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="flex flex-1">
{{-- ── Admin Sidebar ─────────────────────────────────────────── --}}
<aside class="w-60 flex-shrink-0 bg-white border-r border-slate-100 min-h-full hidden md:block">
    <nav class="p-3 space-y-0.5">

        @php
        $adminLinks = [
            ['route' => 'admin.dashboard',                  'label' => 'Dashboard',              'icon' => 'home'],
            ['route' => 'admin.products',                   'label' => 'Kelola Produk',           'icon' => 'package'],
            ['route' => 'admin.users',                      'label' => 'Kelola User',             'icon' => 'users'],
            ['route' => 'admin.categories',                 'label' => 'Kategori',                'icon' => 'tag'],
            ['route' => 'admin.banners',                    'label' => 'Banner',                  'icon' => 'image'],
            ['route' => 'admin.merchant-applications.index','label' => 'Pendaftaran Merchant',    'icon' => 'store'],
        ];
        @endphp

        @foreach($adminLinks as $link)
        @php $active = request()->routeIs($link['route'].'*'); @endphp
        <a href="{{ route($link['route']) }}"
           class="flex items-center gap-3 rounded-2xl px-3 py-2.5 text-sm font-semibold transition-all duration-200
                  {{ $active ? 'bg-rose-50 text-rose-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
            {{-- Icon --}}
            <span class="h-8 w-8 flex-shrink-0 flex items-center justify-center rounded-xl
                         {{ $active ? 'bg-rose-100 text-rose-600' : 'bg-slate-100 text-slate-500' }} transition-colors">
                @if($link['icon'] === 'home')
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
                @elseif($link['icon'] === 'package')
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3z"/></svg>
                @elseif($link['icon'] === 'users')
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/></svg>
                @elseif($link['icon'] === 'tag')
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/></svg>
                @elseif($link['icon'] === 'image')
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                @elseif($link['icon'] === 'store')
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/><path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9z" clip-rule="evenodd"/></svg>
                @endif
            </span>
            <span class="flex-1">{{ $link['label'] }}</span>
            @if($link['route'] === 'admin.merchant-applications.index')
                @php $pendingCount = \App\Models\MerchantApplication::where('status','pending')->count(); @endphp
                @if($pendingCount > 0)
                    <span class="badge badge-rose text-[10px] min-w-[20px] text-center">{{ $pendingCount }}</span>
                @endif
            @endif
        </a>
        @endforeach
    </nav>
</aside>

{{-- ── Admin Content Area ────────────────────────────────────── --}}
<main class="flex-1 overflow-auto p-6">
    {{-- Flash messages --}}
    @if(session('success'))
    <div class="alert alert-success mb-5">
        <div class="alert-icon bg-emerald-500">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <p class="font-semibold">{{ session('success') }}</p>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-error mb-5">
        <div class="alert-icon bg-rose-500">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01"/>
            </svg>
        </div>
        <p class="font-semibold">{{ session('error') }}</p>
    </div>
    @endif

    @yield('content')
</main>
</div>

{{-- ── Admin Footer ──────────────────────────────────────────── --}}
<footer class="border-t border-slate-200 bg-white py-4">
    <div class="px-6 flex items-center justify-between text-xs text-slate-400">
        <span class="font-bold text-rose-600">Super Admin Panel</span>
        <span>&copy; {{ date('Y') }} GadgetHub</span>
    </div>
</footer>

<script>
(function () {
    const toggle   = document.getElementById('admin-profile-toggle');
    const dropdown = document.getElementById('admin-dropdown');
    const wrap     = document.getElementById('admin-profile-wrap');
    if (toggle && dropdown) {
        toggle.addEventListener('click', function (e) {
            e.stopPropagation();
            dropdown.classList.toggle('hidden');
        });
        document.addEventListener('click', function (e) {
            if (!wrap?.contains(e.target)) dropdown.classList.add('hidden');
        });
    }
    // Legacy alias
    window.toggleDropdown = function () {
        if (dropdown) dropdown.classList.toggle('hidden');
    };
})();
</script>
@stack('scripts')
</body>
</html>
