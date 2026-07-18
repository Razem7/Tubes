@extends('layouts.app')

@section('title', 'GadgetHub - Edit Profil')

@section('content')
<div class="max-w-2xl mx-auto">

    {{-- Tab Navigation --}}
    <div class="flex border-b border-gray-200 mb-6">
        <button onclick="showTab('profil')" id="tab-profil"
            class="tab-btn px-6 py-3 text-sm font-medium border-b-2 border-blue-600 text-blue-600 focus:outline-none">
            Edit Profil
        </button>
        <button onclick="showTab('password')" id="tab-password"
            class="tab-btn px-6 py-3 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none">
            Ganti Password
        </button>
    </div>

    {{-- ── TAB: EDIT PROFIL ── --}}
    <div id="pane-profil">
        <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold mb-6">Edit Profil</h2>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Foto Profil --}}
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Foto Profil Saat Ini</label>
                    <img src="{{ $user->profile_photo_url ? asset('storage/' . $user->profile_photo_url) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&size=200' }}"
                         alt="{{ $user->name }}"
                         class="w-24 h-24 rounded-full object-cover mb-2">
                </div>

                <div class="mb-4">
                    <label for="profile_photo" class="block text-gray-700 mb-2">Upload Foto Profil Baru</label>
                    <input type="file"
                           id="profile_photo"
                           name="profile_photo"
                           accept="image/jpeg,image/png,image/jpg"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG. Maksimal 5MB</p>
                    @error('profile_photo')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nama --}}
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 mb-2">Nama Lengkap *</label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name', $user->name) }}"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                           required>
                    @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nomor HP --}}
                <div class="mb-4">
                    <label for="phone_number" class="block text-gray-700 mb-2">Nomor HP</label>
                    <input type="text"
                           id="phone_number"
                           name="phone_number"
                           value="{{ old('phone_number', $user->phone_number) }}"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- Alamat — hanya user biasa & merchant --}}
                @if(! auth()->user()->isSuperAdmin())
                <div class="mb-4">
                    <label for="address" class="block text-gray-700 mb-2">Alamat Lengkap</label>
                    <textarea id="address"
                              name="address"
                              rows="4"
                              placeholder="Contoh: Jl. Mawar No. 12, RT 03/RW 05, Kel. Sukamaju, Kec. Cimahi Tengah, Kota Cimahi, Jawa Barat 40522"
                              class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none @error('address') border-red-500 @enderror">{{ old('address', $user->address) }}</textarea>
                    <p class="text-xs text-gray-400 mt-1">Alamat ini akan otomatis terisi saat checkout.</p>
                    @error('address')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                @endif

                {{-- Email (read-only) --}}
                <div class="mb-4 bg-gray-100 p-4 rounded-lg">
                    <p class="text-sm text-gray-600">Email: {{ $user->email }}</p>
                    <p class="text-xs text-gray-500 mt-1">Email tidak dapat diubah</p>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('profile.show') }}" class="flex-1 bg-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-400 text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- ── TAB: GANTI PASSWORD ── --}}
    <div id="pane-password" class="hidden">
        <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold mb-6">Ganti Password</h2>

            @if(session('success_password'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success_password') }}
                </div>
            @endif

            <form action="{{ route('profile.password') }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Password Saat Ini --}}
                <div class="mb-4">
                    <label for="current_password" class="block text-gray-700 mb-2">Password Saat Ini *</label>
                    <div class="relative">
                        <input type="password"
                               id="current_password"
                               name="current_password"
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 pr-10 @error('current_password') border-red-500 @enderror"
                               required>
                        <button type="button" onclick="togglePw('current_password', this)"
                                class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                    @error('current_password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password Baru --}}
                <div class="mb-4">
                    <label for="new_password" class="block text-gray-700 mb-2">Password Baru *</label>
                    <div class="relative">
                        <input type="password"
                               id="new_password"
                               name="new_password"
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 pr-10 @error('new_password') border-red-500 @enderror"
                               required>
                        <button type="button" onclick="togglePw('new_password', this)"
                                class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                    <p class="text-xs text-gray-400 mt-1">Minimal 8 karakter.</p>
                    @error('new_password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Konfirmasi Password Baru --}}
                <div class="mb-6">
                    <label for="new_password_confirmation" class="block text-gray-700 mb-2">Konfirmasi Password Baru *</label>
                    <div class="relative">
                        <input type="password"
                               id="new_password_confirmation"
                               name="new_password_confirmation"
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 pr-10"
                               required>
                        <button type="button" onclick="togglePw('new_password_confirmation', this)"
                                class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                        Simpan Password
                    </button>
                    <a href="{{ route('profile.show') }}" class="flex-1 bg-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-400 text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
function showTab(tab) {
    // Sembunyikan semua pane
    document.getElementById('pane-profil').classList.add('hidden');
    document.getElementById('pane-password').classList.add('hidden');

    // Reset semua tab button
    document.getElementById('tab-profil').classList.remove('border-blue-600', 'text-blue-600');
    document.getElementById('tab-profil').classList.add('border-transparent', 'text-gray-500');
    document.getElementById('tab-password').classList.remove('border-blue-600', 'text-blue-600');
    document.getElementById('tab-password').classList.add('border-transparent', 'text-gray-500');

    // Tampilkan pane yang dipilih
    document.getElementById('pane-' + tab).classList.remove('hidden');
    document.getElementById('tab-' + tab).classList.add('border-blue-600', 'text-blue-600');
    document.getElementById('tab-' + tab).classList.remove('border-transparent', 'text-gray-500');
}

// Toggle show/hide password
function togglePw(fieldId, btn) {
    const input = document.getElementById(fieldId);
    input.type = input.type === 'password' ? 'text' : 'password';
}

// Otomatis buka tab password jika ada error / success di sana
document.addEventListener('DOMContentLoaded', function () {
    const hasPasswordTab = {{ session('password_tab') || $errors->has('current_password') || $errors->has('new_password') || session('success_password') ? 'true' : 'false' }};
    if (hasPasswordTab) {
        showTab('password');
    }
});
</script>
@endsection
