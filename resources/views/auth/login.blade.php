@extends('layouts.app')

@section('title', 'GadgetHub - Login')

@section('content')
<div class="flex min-h-[calc(100vh-64px)] items-center justify-center bg-slate-50 px-4 py-10">
    <div class="w-full max-w-sm">
        <div class="mb-8 text-center">
            <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center gap-2">
                <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-600 to-sky-500 shadow-lg shadow-blue-600/20">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span class="text-2xl font-extrabold tracking-tight text-blue-700">GadgetHub</span>
            </a>
            <p class="mt-2 text-sm text-slate-500">Selamat datang kembali 👋</p>
        </div>

        <div class="rounded-[28px] border border-slate-200 bg-white/90 p-8 shadow-[0_20px_60px_-30px_rgba(15,23,42,0.35)] backdrop-blur-sm">
            <h1 class="mb-6 text-xl font-bold text-slate-900">Masuk ke akun kamu</h1>

            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="email" class="mb-1.5 block text-sm font-medium text-slate-700">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="contoh@email.com" class="input-field {{ $errors->has('email') ? 'border-rose-300 bg-rose-50 focus:border-rose-400 focus:ring-rose-100' : '' }}" required autocomplete="email">
                    @error('email')
                        <p class="mt-1 flex items-center gap-1 text-xs text-rose-500">
                            <svg class="h-3 w-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="mb-1.5 block text-sm font-medium text-slate-700">Password</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" placeholder="••••••••" class="input-field pr-10 {{ $errors->has('password') ? 'border-rose-300 bg-rose-50 focus:border-rose-400 focus:ring-rose-100' : '' }}" required>
                        <button type="button" onclick="togglePassword('password','eyeIcon1')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                            <svg id="eyeIcon1" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember" class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    <label for="remember" class="ml-2 text-sm text-slate-600">Ingat saya</label>
                </div>

                <button type="submit" class="w-full rounded-2xl bg-gradient-to-r from-blue-600 to-sky-500 py-3 text-sm font-semibold text-white transition hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Masuk
                </button>
            </form>

            <div class="relative my-5">
                <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-200"></div></div>
                <div class="relative flex justify-center"><span class="bg-white px-3 text-xs text-slate-400">atau</span></div>
            </div>

            <p class="text-center text-sm text-slate-600">
                Belum punya akun?
                <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:underline">Daftar gratis</a>
            </p>
        </div>

        <p class="mt-6 text-center text-xs text-slate-400">Dengan masuk, kamu menyetujui syarat & ketentuan GadgetHub.</p>
    </div>
</div>

@push('scripts')
<script>
function togglePassword(inputId, iconId) {
    var input = document.getElementById(inputId);
    var icon  = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';
    } else {
        input.type = 'password';
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
    }
}
</script>
@endpush

@endsection
