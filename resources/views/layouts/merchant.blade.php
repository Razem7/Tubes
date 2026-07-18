<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Merchant - GadgetHub')</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="alternate icon" href="/favicon.ico">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">

    <!-- Top Navbar -->
    <nav class="bg-white shadow-sm border-b">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('merchant.dashboard') }}" class="flex items-center gap-2 flex-shrink-0">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0" style="background: linear-gradient(135deg, #1d4ed8, #3b82f6);">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="leading-tight">
                        <span class="block text-base font-extrabold tracking-tight text-blue-700">GadgetHub</span>
                        <span class="block text-xs font-semibold text-purple-600 -mt-0.5">Merchant Panel</span>
                    </div>
                </a>
                <div class="flex items-center gap-4">
                    <a href="{{ route('products.index') }}" target="_blank" class="text-sm text-gray-600 hover:text-blue-600">
                        Lihat Toko ↗
                    </a>
                    <div class="relative">
                        <button type="button" class="flex items-center gap-2 text-gray-700" onclick="toggleDropdown()">
                            <div class="relative">
                                <img src="{{ auth()->user()->profile_photo_url ? asset('storage/' . auth()->user()->profile_photo_url) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=7c3aed&color=fff' }}"
                                     alt="Profile" class="w-8 h-8 rounded-full object-cover">
                                <span id="profile-dot" style="display:none; position:absolute; top:-2px; right:-2px; width:11px; height:11px; background:#ef4444; border:2px solid #fff; border-radius:50%;"></span>
                            </div>
                            <span class="text-sm font-medium">{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div id="dropdown" class="hidden absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-xl border border-gray-100 py-1 z-50">
                            <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Profil Saya</a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex flex-1">
        <!-- Sidebar -->
        <aside class="w-64 bg-white min-h-screen shadow-sm flex-shrink-0">
            <div class="p-4">
                <nav class="space-y-1">
                    <a href="{{ route('merchant.dashboard') }}"
                       class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('merchant.dashboard') ? 'bg-purple-50 text-purple-700' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
                        Dashboard
                    </a>
                    <a href="{{ route('merchant.products') }}"
                       class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('merchant.products*') ? 'bg-purple-50 text-purple-700' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/></svg>
                        Produk Saya
                    </a>
                    <a href="{{ route('merchant.stock') }}"
                       class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('merchant.stock*') ? 'bg-purple-50 text-purple-700' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"/></svg>
                        Manajemen Stok
                    </a>
                    <a href="{{ route('chats.index') }}"
                       class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('chats*') ? 'bg-purple-50 text-purple-700' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        <span class="flex-1">Chat</span>
                        <span id="sidebar-chat-badge" style="display:none;" class="bg-red-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full min-w-[20px] text-center"></span>
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6 overflow-auto">
            @if(session('success'))
            <div class="bg-green-50 border border-green-300 text-green-700 px-4 py-3 rounded-lg mb-4 text-sm flex items-center gap-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm flex items-center gap-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-9v4a1 1 0 002 0V9a1 1 0 00-2 0zm0-4a1 1 0 112 0 1 1 0 01-2 0z" clip-rule="evenodd"/></svg>
                {{ session('error') }}
            </div>
            @endif
            @yield('content')
        </main>
    </div>

    <footer class="bg-gray-800 text-white py-3">
        <div class="container mx-auto px-4 flex justify-between items-center text-xs text-gray-400">
            <span class="text-purple-400 font-semibold">Merchant Panel — GadgetHub</span>
            <span>&copy; {{ date('Y') }} GadgetHub</span>
        </div>
    </footer>

    <script>
        function toggleDropdown() {
            document.getElementById('dropdown').classList.toggle('hidden');
        }
        window.addEventListener('click', function(e) {
            if (!e.target.closest('.relative')) {
                const dd = document.getElementById('dropdown');
                if (dd) dd.classList.add('hidden');
            }
        });

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

                // Profile dot: hanya nyala jika ada transaksi yang butuh aksi
                const profileDot = document.getElementById('profile-dot');
                if (profileDot) profileDot.style.display = trxCount > 0 ? 'block' : 'none';

                // Badge chat di sidebar
                const chatBadge = document.getElementById('sidebar-chat-badge');
                if (chatBadge) {
                    chatBadge.textContent    = chatCount;
                    chatBadge.style.display  = chatCount > 0 ? 'inline-block' : 'none';
                }

                // Badge transaksi di sidebar — sudah dipindah ke dashboard, tidak perlu lagi
            }).catch(() => {});
        }

        // Jalankan langsung dan polling tiap 15 detik
        updateDots();
        setInterval(updateDots, 15000);
        @endauth
    </script>
    @stack('scripts')
</body>
</html>
