<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'GadgetHub - Marketplace HP Bekas')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm border-b">
        <div class="container mx-auto max-w-screen-xl px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('products.index') }}" class="text-xl font-bold text-blue-600">
                        GadgetHub
                    </a>
                    <div class="hidden md:flex space-x-4">
                        <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-blue-600">
                            Jelajah
                        </a>
                        @auth
                        <a href="{{ route('products.my') }}" class="text-gray-700 hover:text-blue-600">
                            Produk Saya
                        </a>
                        <a href="{{ route('favorites.index') }}" class="text-gray-700 hover:text-blue-600">
                            Favorit
                        </a>
                        <a href="{{ route('chats.index') }}" class="text-gray-700 hover:text-blue-600">
                            Chat
                        </a>
                        @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-600">
                            Admin
                        </a>
                        @endif
                        @endauth
                    </div>
                </div>
                
                <div class="hidden md:flex items-center space-x-4">
                    @auth
                    <a href="{{ route('products.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        Pasang Iklan
                    </a>
                    <div class="relative">
                        <button type="button" class="flex items-center space-x-2 text-gray-700" onclick="toggleDropdown()">
                            <img src="{{ auth()->user()->profile_photo_url ? asset('storage/' . auth()->user()->profile_photo_url) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}" 
                                 alt="Profile" 
                                 class="w-8 h-8 rounded-full object-cover">
                            <span>{{ auth()->user()->name }}</span>
                        </button>
                        <div id="dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-10">
                            <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                Profil
                            </a>
                            @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                Admin Dashboard
                            </a>
                            @endif
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                    @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        Daftar
                    </a>
                    @endauth
                </div>

                <button type="button" class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:bg-gray-100" onclick="toggleMobileMenu()" aria-expanded="false" aria-label="Toggle navigation menu">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <div id="mobile-menu" class="hidden md:hidden border-t border-gray-200 pt-3 pb-4">
                <div class="space-y-1 px-2">
                    <a href="{{ route('products.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100">
                        Jelajah
                    </a>
                    @auth
                    <a href="{{ route('products.my') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100">
                        Produk Saya
                    </a>
                    <a href="{{ route('favorites.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100">
                        Favorit
                    </a>
                    <a href="{{ route('chats.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100">
                        Chat
                    </a>
                    @if(auth()->user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100">
                        Admin
                    </a>
                    @endif
                    <a href="{{ route('products.create') }}" class="block px-3 py-2 rounded-md bg-blue-600 text-white text-base font-medium hover:bg-blue-700">
                        Pasang Iklan
                    </a>
                    <a href="{{ route('profile.show') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100">
                        Profil
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100">
                            Logout
                        </button>
                    </form>
                    @else
                    <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="block px-3 py-2 rounded-md bg-blue-600 text-white text-base font-medium hover:bg-blue-700">
                        Daftar
                    </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
    <div class="container mx-auto px-4 mt-4">
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="container mx-auto px-4 mt-4">
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            {{ session('error') }}
        </div>
    </div>
    @endif

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-6">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-12 py-8">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <p class="text-sm">&copy; 2024 GadgetHub. Platform jual beli HP bekas terpercaya.</p>
                <p class="text-xs text-gray-400 mt-2">Daffa Azaria & Rao Azeem Samudra - D4 Teknik Informatika</p>
            </div>
        </div>
    </footer>

    <script>
        function toggleDropdown() {
            document.getElementById('dropdown').classList.toggle('hidden');
        }

        function toggleMobileMenu() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        }

        // Close dropdown when clicking outside
        window.addEventListener('click', function(e) {
            if (!e.target.matches('button') && !e.target.closest('.relative')) {
                var dropdown = document.getElementById('dropdown');
                if (dropdown && !dropdown.classList.contains('hidden')) {
                    dropdown.classList.add('hidden');
                }
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
