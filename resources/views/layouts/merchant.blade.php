<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Merchant — GadgetHub')</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="alternate icon" href="/favicon.ico">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 flex flex-col min-h-screen font-sans antialiased">

{{-- ── Merchant Top Navbar ──────────────────────────────────── --}}
<header class="sticky top-0 z-50 flex h-16 items-center border-b border-slate-200/70 bg-white/90 backdrop-blur-xl shadow-nav">
    <div class="flex w-full items-center justify-between px-6">

        {{-- Brand --}}
        <a href="{{ route('merchant.dashboard') }}" class="flex items-center gap-2.5">
            <div class="flex h-8 w-8 items-center justify-center rounded-xl"
                 style="background: linear-gradient(135deg, #7c3aed 0%, #4f46e5 100%);">
                <svg class="h-4.5 w-4.5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="leading-tight">
                <span class="block text-sm font-extrabold tracking-tight text-slate-900">GadgetHub</span>
                <span class="block text-[10px] font-bold uppercase tracking-widest text-purple-600">Merchant Panel</span>
            </div>
        </a>

        {{-- Right side --}}
        <div class="flex items-center gap-4">
            <a href="{{ route('products.index') }}" target="_blank"
               class="hidden items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-600 hover:border-slate-300 hover:text-slate-800 transition-colors sm:flex">
                Lihat Toko
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
            </a>
            <div class="relative" id="merchant-profile-wrap">
                <button type="button" id="merchant-profile-toggle"
                        class="flex items-center gap-2.5 rounded-2xl border border-slate-200 bg-white py-1.5 pl-1.5 pr-3 hover:bg-slate-50 transition-colors">
                    <div class="relative">
                        <img src="{{ auth()->user()->profile_photo_url
                            ? asset('storage/'.auth()->user()->profile_photo_url)
                            : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=7c3aed&color=fff' }}"
                             alt="Profil" class="avatar avatar-sm">
                        <span id="profile-dot" style="display:none;"
                              class="absolute -right-0.5 -top-0.5 h-2.5 w-2.5 rounded-full bg-rose-500 ring-2 ring-white"></span>
                    </div>
                    <span class="text-xs font-semibold text-slate-700 hidden sm:block max-w-[100px] truncate">
                        {{ auth()->user()->name }}
                    </span>
                    <svg class="h-3.5 w-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div id="merchant-dropdown"
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
{{-- ── Merchant Sidebar ─────────────────────────────────────── --}}
<aside class="w-60 flex-shrink-0 bg-white border-r border-slate-100 min-h-full hidden md:block">
    <nav class="p-3 space-y-0.5">

        @php
        $merchantLinks = [
            ['route' => 'merchant.dashboard', 'pattern' => 'merchant.dashboard', 'label' => 'Dashboard',        'icon' => 'home'],
            ['route' => 'merchant.products',  'pattern' => 'merchant.products*', 'label' => 'Produk Saya',      'icon' => 'package'],
            ['route' => 'merchant.stock',     'pattern' => 'merchant.stock*',    'label' => 'Manajemen Stok',   'icon' => 'stock'],
            ['route' => 'chats.index',        'pattern' => 'chats*',             'label' => 'Pesan',            'icon' => 'chat', 'badge' => 'chat'],
        ];
        @endphp

        @foreach($merchantLinks as $link)
        @php $active = request()->routeIs($link['pattern']); @endphp
        <a href="{{ route($link['route']) }}"
           class="flex items-center gap-3 rounded-2xl px-3 py-2.5 text-sm font-semibold transition-all duration-200
                  {{ $active ? 'bg-purple-50 text-purple-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
            <span class="h-8 w-8 flex-shrink-0 flex items-center justify-center rounded-xl
                         {{ $active ? 'bg-purple-100 text-purple-600' : 'bg-slate-100 text-slate-500' }} transition-colors">
                @if($link['icon'] === 'home')
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
                @elseif($link['icon'] === 'package')
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3z"/></svg>
                @elseif($link['icon'] === 'stock')
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"/></svg>
                @elseif($link['icon'] === 'chat')
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                @endif
            </span>
            <span class="flex-1">{{ $link['label'] }}</span>
            @if(isset($link['badge']) && $link['badge'] === 'chat')
                <span id="sidebar-chat-badge" style="display:none;"
                      class="badge badge-rose text-[10px] min-w-[20px] text-center"></span>
            @endif
        </a>
        @endforeach
    </nav>
</aside>

{{-- ── Merchant Content Area ────────────────────────────────── --}}
<main class="flex-1 overflow-auto p-6">
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

{{-- ── Merchant Footer ──────────────────────────────────────── --}}
<footer class="border-t border-slate-200 bg-white py-4">
    <div class="px-6 flex items-center justify-between text-xs text-slate-400">
        <span class="font-bold text-purple-600">Merchant Panel</span>
        <span>&copy; {{ date('Y') }} GadgetHub</span>
    </div>
</footer>

<script>
(function () {
    const toggle   = document.getElementById('merchant-profile-toggle');
    const dropdown = document.getElementById('merchant-dropdown');
    const wrap     = document.getElementById('merchant-profile-wrap');
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

@auth
const UNREAD_CHATS_URL = '{{ route("notifications.unread-chats") }}';
const UNREAD_TRX_URL   = '{{ route("notifications.unread-transactions") }}';
const CSRF             = document.querySelector('meta[name="csrf-token"]').content;

function updateDots() {
    Promise.all([
        fetch(UNREAD_CHATS_URL, { credentials: 'same-origin', headers: { 'X-Requested-With': 'XMLHttpRequest' } }).then(r => r.ok ? r.json() : null),
        fetch(UNREAD_TRX_URL,   { credentials: 'same-origin', headers: { 'X-Requested-With': 'XMLHttpRequest' } }).then(r => r.ok ? r.json() : null),
    ]).then(([chatData, trxData]) => {
        const chatCount = chatData?.count ?? 0;
        const trxCount  = trxData?.count  ?? 0;
        const profileDot = document.getElementById('profile-dot');
        if (profileDot) profileDot.style.display = trxCount > 0 ? 'block' : 'none';
        const chatBadge = document.getElementById('sidebar-chat-badge');
        if (chatBadge) {
            chatBadge.textContent   = chatCount;
            chatBadge.style.display = chatCount > 0 ? 'inline-flex' : 'none';
        }
    }).catch(() => {});
}
updateDots();
setInterval(updateDots, 15000);
@endauth
</script>
@stack('scripts')
</body>
</html>
