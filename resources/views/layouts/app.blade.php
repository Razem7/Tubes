<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'GadgetHub - Marketplace Gadget Bekas')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">

    <!-- Navbar -->
    <nav class="bg-white shadow-sm sticky top-0 z-50" style="overflow:visible;">
        <div class="max-w-screen-xl mx-auto px-4" style="overflow:visible;">

            <!-- Top bar -->
            <div class="flex items-center gap-3 h-16">

                <!-- Logo -->
                <a href="{{ route('products.index') }}" class="flex-shrink-0 flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0" style="background: linear-gradient(135deg, #1d4ed8, #3b82f6);">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <span class="text-xl font-extrabold tracking-tight" style="background: linear-gradient(135deg, #1d4ed8, #3b82f6); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">GadgetHub</span>
                </a>

                <!-- Search bar (desktop) -->
                <form action="{{ route('products.index') }}" method="GET" class="hidden md:flex flex-1 mx-4">
                    <div class="flex w-full rounded-lg border border-gray-300 overflow-hidden focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari gadget bekas..."
                            class="flex-1 px-4 py-2 text-sm outline-none bg-white"
                        >
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 text-sm font-medium flex items-center gap-1 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                            </svg>
                            Cari
                        </button>
                    </div>
                </form>

                <!-- Right actions (desktop) -->
                <div class="hidden md:flex items-center gap-2 flex-shrink-0">
                    @auth
                        @if(!auth()->user()->is_admin)
                            <a href="{{ route('products.create') }}" class="flex items-center gap-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Pasang Iklan
                            </a>
                        @endif

                        <!-- User dropdown -->
                        <div class="relative">
                            <button type="button" onclick="toggleDropdown()" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-100 transition">
                                <img src="{{ auth()->user()->profile_photo_url ? asset('storage/' . auth()->user()->profile_photo_url) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=2563eb&color=fff' }}"
                                     alt="Profile"
                                     class="w-8 h-8 rounded-full object-cover">
                                <span class="text-sm font-medium text-gray-700 max-w-[100px] truncate">{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div id="dropdown" class="hidden absolute right-0 mt-1 w-52 bg-white rounded-xl shadow-xl border border-gray-100 py-1" style="z-index:9999; top:100%;">
                                @if(!auth()->user()->is_admin)
                                    <a href="{{ route('products.my') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7H4a2 2 0 00-2 2v6a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 3H8l-2 4h12l-2-4z"/></svg>
                                        Produk Saya
                                    </a>
                                    <a href="{{ route('favorites.index') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                        Favorit
                                    </a>
                                    <a href="{{ route('chats.index') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                        Chat
                                    </a>
                                    <a href="{{ route('transactions.index') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                        Transaksi
                                    </a>
                                    <div class="border-t border-gray-100 my-1"></div>
                                @endif
                                <a href="{{ route('profile.show') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    Profil Saya
                                </a>
                                @if(auth()->user()->is_admin)
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-blue-600 hover:bg-blue-50 font-medium">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                                        Admin Dashboard
                                    </a>
                                @endif
                                <div class="border-t border-gray-100 my-1"></div>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-2 w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h6a2 2 0 012 2v1"/></svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>

                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700 px-3 py-2">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="text-sm font-semibold bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                            Daftar
                        </a>
                        <a href="{{ route('products.create') }}" class="flex items-center gap-1 border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Pasang Iklan
                        </a>
                    @endauth
                </div>

                <!-- Mobile: search icon + hamburger -->
                <div class="flex items-center gap-2 md:hidden ml-auto">
                    <button type="button" onclick="toggleMobileSearch()" class="p-2 rounded-md text-gray-600 hover:bg-gray-100" aria-label="Cari">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                        </svg>
                    </button>
                    <button type="button" onclick="toggleMobileMenu()" class="p-2 rounded-md text-gray-600 hover:bg-gray-100" aria-label="Menu">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile search bar (hidden by default) -->
            <div id="mobile-search" class="hidden md:hidden pb-3">
                <form action="{{ route('products.index') }}" method="GET" class="flex rounded-lg border border-gray-300 overflow-hidden focus-within:border-blue-500">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari gadget bekas..."
                        class="flex-1 px-4 py-2 text-sm outline-none"
                    >
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                        </svg>
                    </button>
                </form>
            </div>

            <!-- Mobile menu -->
            <div id="mobile-menu" class="hidden md:hidden border-t border-gray-100 py-2">
                @auth
                    <!-- User info -->
                    <div class="flex items-center gap-3 px-4 py-3 mb-1">
                        <img src="{{ auth()->user()->profile_photo_url ? asset('storage/' . auth()->user()->profile_photo_url) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=2563eb&color=fff' }}"
                             alt="Profile" class="w-10 h-10 rounded-full object-cover">
                        <div>
                            <p class="font-semibold text-sm text-gray-800">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    <div class="border-t border-gray-100 mb-1"></div>
                    @if(!auth()->user()->is_admin)
                        <a href="{{ route('products.create') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-semibold text-blue-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Pasang Iklan
                        </a>
                        <a href="{{ route('products.my') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/></svg>
                            Produk Saya
                        </a>
                        <a href="{{ route('favorites.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                            Favorit
                        </a>
                        <a href="{{ route('chats.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                            Chat
                        </a>
                        <a href="{{ route('transactions.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            Transaksi
                        </a>
                    @else
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-semibold text-blue-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                            Admin Dashboard
                        </a>
                    @endif
                    <a href="{{ route('profile.show') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Profil Saya
                    </a>
                    <div class="border-t border-gray-100 mt-1 pt-1">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="flex items-center gap-3 w-full px-4 py-2.5 text-sm text-red-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h6a2 2 0 012 2v1"/></svg>
                                Logout
                            </button>
                        </form>
                    </div>
                @else
                    <div class="px-4 py-3 flex flex-col gap-2">
                        <a href="{{ route('register') }}" class="block text-center bg-blue-600 text-white text-sm font-semibold py-2.5 rounded-lg">
                            Daftar
                        </a>
                        <a href="{{ route('login') }}" class="block text-center border border-blue-600 text-blue-600 text-sm font-semibold py-2.5 rounded-lg">
                            Login
                        </a>
                        <a href="{{ route('products.create') }}" class="block text-center border border-gray-300 text-gray-700 text-sm py-2.5 rounded-lg">
                            + Pasang Iklan
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
    <div class="max-w-screen-xl mx-auto px-4 mt-3">
        <div class="bg-green-50 border border-green-300 text-green-700 px-4 py-3 rounded-lg text-sm flex items-center gap-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            {{ session('success') }}
        </div>
    </div>
    @endif
    @if(session('error'))
    <div class="max-w-screen-xl mx-auto px-4 mt-3">
        <div class="bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-lg text-sm flex items-center gap-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-9v4a1 1 0 002 0V9a1 1 0 00-2 0zm0-4a1 1 0 112 0 1 1 0 01-2 0z" clip-rule="evenodd"/></svg>
            {{ session('error') }}
        </div>
    </div>
    @endif

    <!-- Main Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-8 py-4">
        <div class="max-w-screen-xl mx-auto px-4">
            <div class="flex justify-center items-center">
                <p class="text-xs text-gray-400">&copy; 2025 GadgetHub. Platform jual beli gadget bekas terpercaya.</p>
            </div>
        </div>
    </footer>

    <!-- Login Required Modal -->
    <div id="loginModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.55); z-index:9999; align-items:center; justify-content:center; padding:1rem;">
        <div style="background:#fff; border-radius:1rem; box-shadow:0 20px 60px rgba(0,0,0,0.3); width:100%; max-width:360px; padding:1.5rem; position:relative;">
            <button onclick="closeLoginModal()" style="position:absolute; top:0.75rem; right:0.75rem; background:none; border:none; cursor:pointer; color:#9ca3af; font-size:1.25rem; line-height:1;" aria-label="Tutup">&times;</button>
            <div style="text-align:center; margin-bottom:1.25rem;">
                <div style="width:56px; height:56px; background:#dbeafe; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 0.75rem;">
                    <svg style="width:28px;height:28px;color:#2563eb;" fill="none" stroke="#2563eb" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <h3 style="font-size:1.1rem; font-weight:700; color:#111827; margin:0 0 0.25rem;">Login Diperlukan</h3>
                <p id="loginModalMessage" style="font-size:0.875rem; color:#6b7280; margin:0;">Silakan login untuk melanjutkan.</p>
            </div>
            <div style="display:flex; flex-direction:column; gap:0.5rem;">
                <a href="{{ route('login') }}" style="display:block; text-align:center; background:#2563eb; color:#fff; font-weight:600; padding:0.75rem; border-radius:0.5rem; text-decoration:none; font-size:0.875rem;">
                    Login
                </a>
                <a href="{{ route('register') }}" style="display:block; text-align:center; border:1px solid #d1d5db; color:#374151; font-weight:500; padding:0.75rem; border-radius:0.5rem; text-decoration:none; font-size:0.875rem;">
                    Belum punya akun? Daftar
                </a>
            </div>
        </div>
    </div>

    <script>
        function toggleDropdown() {
            document.getElementById('dropdown').classList.toggle('hidden');
        }
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
            // close search if open
            document.getElementById('mobile-search').classList.add('hidden');
        }
        function toggleMobileSearch() {
            const search = document.getElementById('mobile-search');
            search.classList.toggle('hidden');
            // close menu if open
            document.getElementById('mobile-menu').classList.add('hidden');
            if (!search.classList.contains('hidden')) {
                search.querySelector('input').focus();
            }
        }
        window.addEventListener('click', function(e) {
            if (!e.target.closest('.relative')) {
                const dd = document.getElementById('dropdown');
                if (dd) dd.classList.add('hidden');
            }
        });

        // Login modal
        function showLoginModal(message) {
            var modal = document.getElementById('loginModal');
            var msg = document.getElementById('loginModalMessage');
            if (!modal || !msg) return;
            msg.textContent = message || 'Silakan login untuk melanjutkan.';
            modal.style.display = 'flex';
        }
        function closeLoginModal() {
            var modal = document.getElementById('loginModal');
            if (modal) modal.style.display = 'none';
        }
        var loginModalEl = document.getElementById('loginModal');
        if (loginModalEl) {
            loginModalEl.addEventListener('click', function(e) {
                if (e.target === this) closeLoginModal();
            });
        }
    </script>

    @stack('scripts')
</body>
</html>
