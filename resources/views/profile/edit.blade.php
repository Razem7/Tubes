@extends('layouts.app')
@section('title', 'Edit Profil — GadgetHub')

@section('content')
<div class="page-container py-8">
<div class="mx-auto max-w-2xl">

    <div class="mb-6">
        <a href="{{ route('profile.show') }}"
           class="inline-flex items-center gap-1.5 text-sm text-slate-500 transition-colors hover:text-brand-600">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Profil
        </a>
        <div class="mt-3">
            <p class="section-eyebrow">Akun</p>
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Pengaturan Profil</h1>
        </div>
    </div>

    {{-- Tab Navigation --}}
    <div class="mb-6 flex gap-1 rounded-2xl border border-slate-200 bg-slate-100/60 p-1">
        <button onclick="showTab('profil')" id="tab-profil"
                class="tab-btn flex-1 rounded-xl py-2.5 text-sm font-semibold transition-all duration-200 bg-white text-slate-800 shadow-sm">
            Edit Profil
        </button>
        <button onclick="showTab('password')" id="tab-password"
                class="tab-btn flex-1 rounded-xl py-2.5 text-sm font-semibold transition-all duration-200 text-slate-500 hover:text-slate-700">
            Ganti Password
        </button>
    </div>

    {{-- ── TAB: PROFIL ── --}}
    <div id="pane-profil">
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

        <div class="card p-6">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')

                {{-- Current avatar --}}
                <div class="mb-6 flex items-center gap-4">
                    <img src="{{ $user->profile_photo_url
                        ? asset('storage/'.$user->profile_photo_url)
                        : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&size=200&background=4f46e5&color=fff' }}"
                         alt="{{ $user->name }}"
                         id="avatar-preview"
                         class="h-20 w-20 rounded-full border-4 border-white object-cover shadow-card">
                    <div>
                        <label for="profile_photo"
                               class="inline-flex cursor-pointer items-center gap-2 rounded-2xl border border-brand-200 bg-brand-50 px-4 py-2 text-xs font-semibold text-brand-700 transition-colors hover:bg-brand-100">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            Ganti Foto
                        </label>
                        <input type="file" id="profile_photo" name="profile_photo"
                               accept="image/jpeg,image/png,image/jpg" class="hidden"
                               onchange="previewAvatar(this)">
                        <p class="mt-1.5 text-xs text-slate-400">JPG/PNG · maks. 5MB</p>
                        @error('profile_photo')
                        <p class="input-error-msg mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="form-group">
                        <label class="input-label" for="name">Nama Lengkap <span class="text-rose-500">*</span></label>
                        <input type="text" id="name" name="name"
                               value="{{ old('name', $user->name) }}" required
                               class="input-field @error('name') error @enderror">
                        @error('name')
                        <p class="input-error-msg">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="input-label" for="phone_number">Nomor HP</label>
                        <input type="text" id="phone_number" name="phone_number"
                               value="{{ old('phone_number', $user->phone_number) }}"
                               placeholder="08xxxxxxxxxx" class="input-field">
                    </div>

                    @if(!auth()->user()->isSuperAdmin())
                    <div class="form-group">
                        <label class="input-label" for="address">Alamat Lengkap</label>
                        <textarea id="address" name="address" rows="3"
                                  placeholder="Jl. Mawar No. 12, Kel. Sukamaju, Kota Bandung…"
                                  class="input-field @error('address') error @enderror">{{ old('address', $user->address) }}</textarea>
                        <p class="input-hint">Alamat ini akan otomatis terisi saat checkout</p>
                        @error('address')
                        <p class="input-error-msg">{{ $message }}</p>
                        @enderror
                    </div>
                    @endif

                    {{-- Email read-only --}}
                    <div class="rounded-2xl border border-slate-100 bg-slate-50 px-4 py-3">
                        <p class="text-xs font-semibold text-slate-400">Email (tidak dapat diubah)</p>
                        <p class="mt-0.5 text-sm font-semibold text-slate-700">{{ $user->email }}</p>
                    </div>
                </div>

                <div class="mt-6 flex gap-3">
                    <button type="submit" class="btn-primary flex-1 py-3 text-sm font-bold">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('profile.show') }}" class="btn-secondary flex-1 py-3 text-sm text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- ── TAB: PASSWORD ── --}}
    <div id="pane-password" class="hidden">
        @if(session('success_password'))
        <div class="alert alert-success mb-5">
            <div class="alert-icon bg-emerald-500">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <p class="font-semibold">{{ session('success_password') }}</p>
        </div>
        @endif

        <div class="card p-6">
            <form action="{{ route('profile.password') }}" method="POST">
                @csrf @method('PUT')

                <div class="space-y-4">
                    {{-- Password saat ini --}}
                    <div class="form-group">
                        <label class="input-label" for="current_password">
                            Password Saat Ini <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" id="current_password" name="current_password" required
                                   class="input-field pr-11 @error('current_password') error @enderror">
                            <button type="button" onclick="togglePw('current_password', this)"
                                    class="absolute inset-y-0 right-3.5 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        @error('current_password')
                        <p class="input-error-msg">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password baru --}}
                    <div class="form-group">
                        <label class="input-label" for="new_password">
                            Password Baru <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" id="new_password" name="new_password" required
                                   class="input-field pr-11 @error('new_password') error @enderror">
                            <button type="button" onclick="togglePw('new_password', this)"
                                    class="absolute inset-y-0 right-3.5 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        <p class="input-hint">Minimal 8 karakter</p>
                        @error('new_password')
                        <p class="input-error-msg">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Konfirmasi --}}
                    <div class="form-group">
                        <label class="input-label" for="new_password_confirmation">
                            Konfirmasi Password Baru <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" id="new_password_confirmation"
                                   name="new_password_confirmation" required
                                   class="input-field pr-11">
                            <button type="button" onclick="togglePw('new_password_confirmation', this)"
                                    class="absolute inset-y-0 right-3.5 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex gap-3">
                    <button type="submit" class="btn-primary flex-1 py-3 text-sm font-bold">
                        Simpan Password
                    </button>
                    <a href="{{ route('profile.show') }}" class="btn-secondary flex-1 py-3 text-sm text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

</div>
</div>

@push('scripts')
<script>
function showTab(tab) {
    ['profil','password'].forEach(t => {
        document.getElementById('pane-'   + t).classList.toggle('hidden', t !== tab);
        const btn = document.getElementById('tab-' + t);
        if (t === tab) {
            btn.classList.add('bg-white','text-slate-800','shadow-sm');
            btn.classList.remove('text-slate-500');
        } else {
            btn.classList.remove('bg-white','text-slate-800','shadow-sm');
            btn.classList.add('text-slate-500');
        }
    });
}

function togglePw(id, btn) {
    const inp = document.getElementById(id);
    inp.type = inp.type === 'password' ? 'text' : 'password';
}

function previewAvatar(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        const img = document.getElementById('avatar-preview');
        if (img) img.src = e.target.result;
    };
    reader.readAsDataURL(input.files[0]);
}

document.addEventListener('DOMContentLoaded', function () {
    const hasPasswordTab = {{ session('password_tab') || $errors->has('current_password') || $errors->has('new_password') || session('success_password') ? 'true' : 'false' }};
    if (hasPasswordTab) showTab('password');
});
</script>
@endpush

@endsection
