@extends('layouts.app')
@section('title', 'Profil Saya — GadgetHub')

@section('content')
<div class="page-container py-8">
<div class="mx-auto max-w-2xl">

    {{-- Header --}}
    <div class="mb-6 flex items-center justify-between">
        <div>
            <p class="section-eyebrow">Akun</p>
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Profil Saya</h1>
        </div>
        <a href="{{ route('profile.edit') }}" class="btn-primary py-2 px-5 text-sm">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Edit Profil
        </a>
    </div>

    {{-- Avatar + Name card --}}
    <div class="card mb-5 flex flex-col items-start gap-5 p-6 sm:flex-row sm:items-center">
        <div class="relative flex-shrink-0">
            <img src="{{ $user->profile_photo_url
                ? asset('storage/'.$user->profile_photo_url)
                : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&size=200&background=4f46e5&color=fff' }}"
                 alt="{{ $user->name }}"
                 class="h-24 w-24 rounded-full border-4 border-white object-cover shadow-card">
            @if($user->isMerchant())
            <span class="absolute -bottom-1 -right-1 rounded-full border-2 border-white bg-purple-600 px-2 py-0.5 text-[9px] font-extrabold uppercase tracking-wide text-white shadow">
                Merchant
            </span>
            @endif
        </div>
        <div class="min-w-0">
            <h2 class="text-xl font-extrabold text-slate-900">{{ $user->name }}</h2>
            <p class="mt-0.5 text-sm text-slate-400">{{ $user->email }}</p>
            @if($user->phone_verified)
            <span class="mt-2 inline-flex items-center gap-1.5 rounded-xl bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                Nomor HP Terverifikasi
            </span>
            @endif
        </div>
    </div>

    {{-- Info fields --}}
    <div class="card overflow-hidden">
        <div class="divide-y divide-slate-50">
            <div class="flex items-center justify-between px-6 py-4">
                <p class="text-sm text-slate-500">Email</p>
                <p class="text-sm font-semibold text-slate-800">{{ $user->email }}</p>
            </div>
            <div class="flex items-center justify-between px-6 py-4">
                <p class="text-sm text-slate-500">Nomor HP</p>
                <p class="text-sm font-semibold text-slate-800">{{ $user->phone_number ?? '—' }}</p>
            </div>
            @if(!$user->isSuperAdmin())
            <div class="flex items-start justify-between gap-4 px-6 py-4">
                <p class="flex-shrink-0 text-sm text-slate-500">Alamat</p>
                <p class="text-right text-sm font-semibold text-slate-800">{{ $user->address ?? '—' }}</p>
            </div>
            @endif
            <div class="flex items-center justify-between px-6 py-4">
                <p class="text-sm text-slate-500">Bergabung Sejak</p>
                <p class="text-sm font-semibold text-slate-800">{{ $user->created_at->format('d F Y') }}</p>
            </div>
        </div>
    </div>

</div>
</div>
@endsection
