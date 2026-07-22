@extends('layouts.app')
@section('title', 'Status Pendaftaran Merchant — GadgetHub')

@section('content')
<div class="page-container py-16">
<div class="mx-auto max-w-lg">

@if(!$application)
{{-- ── Belum pernah daftar ── --}}
<div class="card p-10 text-center">
    <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-3xl bg-slate-100">
        <svg class="h-8 w-8 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
            <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
            <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
        </svg>
    </div>
    <span class="badge badge-slate mb-3">Belum Terdaftar</span>
    <h2 class="text-xl font-extrabold text-slate-900">Belum Ada Pendaftaran</h2>
    <p class="mt-2 text-sm text-slate-500 leading-relaxed">
        Kamu belum pernah mengajukan pendaftaran merchant. Daftar sekarang dan mulai berjualan di GadgetHub!
    </p>
    <div class="mt-6 flex flex-col items-center gap-3">
        <a href="{{ route('merchant.apply.create') }}" class="btn-merchant w-full py-3.5 text-sm font-bold">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Daftar Merchant Sekarang
        </a>
        <a href="{{ route('products.index') }}" class="text-sm text-slate-400 hover:text-slate-600 transition-colors">
            Kembali ke marketplace
        </a>
    </div>
</div>

@elseif($application->isPending())
{{-- ── Menunggu review ── --}}
<div class="card overflow-hidden p-0 text-center">
    <div class="bg-amber-50 px-10 pt-10 pb-8">
        <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-3xl bg-amber-100">
            <svg class="h-8 w-8 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <span class="badge bg-amber-100 text-amber-700 border-amber-200 mb-3">Menunggu Review</span>
        <h2 class="text-xl font-extrabold text-slate-900">Pendaftaran Sedang Diproses</h2>
    </div>
    <div class="px-10 pb-10 pt-6">
        <p class="text-sm text-slate-600 leading-relaxed">
            Pendaftaran untuk toko <strong class="text-slate-800">{{ $application->store_name }}</strong>
            sedang direview oleh tim GadgetHub.
        </p>
        <div class="mt-5 flex items-center justify-center gap-2 rounded-2xl border border-amber-100 bg-amber-50 px-4 py-3 text-xs text-amber-700">
            <svg class="h-4 w-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            Dikirim {{ $application->created_at->diffForHumans() }} · Proses 1–3 hari kerja
        </div>
        <a href="{{ route('products.index') }}" class="btn-secondary mt-5 w-full py-3 text-sm">
            Kembali ke Marketplace
        </a>
    </div>
</div>

@elseif($application->isApproved())
    @if(auth()->user()->isMerchant())
    {{-- ── Approved & aktif ── --}}
    <div class="card overflow-hidden p-0 text-center">
        <div class="bg-emerald-50 px-10 pt-10 pb-8">
            <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-3xl bg-emerald-100">
                <svg class="h-8 w-8 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <span class="badge badge-emerald mb-3">Disetujui</span>
            <h2 class="text-xl font-extrabold text-slate-900">Selamat! Kamu Sudah Jadi Merchant 🎉</h2>
        </div>
        <div class="px-10 pb-10 pt-6">
            <p class="text-sm text-slate-600 leading-relaxed">
                Toko <strong class="text-slate-800">{{ $application->store_name }}</strong> telah disetujui.
                Mulai upload produkmu sekarang dan raih pelanggan pertamamu!
            </p>
            <div class="mt-5 flex flex-col gap-3">
                <a href="{{ route('merchant.dashboard') }}" class="btn-merchant w-full py-3.5 text-sm font-bold">
                    Masuk ke Dashboard Merchant
                </a>
                <a href="{{ route('merchant.products.create') }}" class="btn-secondary w-full py-3 text-sm">
                    Tambah Produk Pertama
                </a>
            </div>
        </div>
    </div>

    @else
    {{-- ── Approved tapi sudah di-demote ── --}}
    <div class="card overflow-hidden p-0 text-center">
        <div class="bg-orange-50 px-10 pt-10 pb-8">
            <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-3xl bg-orange-100">
                <svg class="h-8 w-8 text-orange-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <span class="badge bg-orange-100 text-orange-700 border-orange-200 mb-3">Akun Diubah</span>
            <h2 class="text-xl font-extrabold text-slate-900">Status Merchant Dicabut</h2>
        </div>
        <div class="px-10 pb-10 pt-6">
            <p class="text-sm text-slate-600 leading-relaxed">
                Akun kamu telah diubah kembali menjadi <strong class="text-slate-800">User Biasa</strong> oleh Admin.
                Kamu bisa mengajukan pendaftaran merchant ulang kapan saja.
            </p>
            <a href="{{ route('merchant.apply.create') }}" class="btn-merchant mt-5 w-full py-3.5 text-sm font-bold">
                Daftar Merchant Lagi
            </a>
        </div>
    </div>
    @endif

@else
{{-- ── Rejected ── --}}
<div class="card overflow-hidden p-0 text-center">
    <div class="bg-rose-50 px-10 pt-10 pb-8">
        <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-3xl bg-rose-100">
            <svg class="h-8 w-8 text-rose-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <span class="badge badge-rose mb-3">Ditolak</span>
        <h2 class="text-xl font-extrabold text-slate-900">Pendaftaran Ditolak</h2>
    </div>
    <div class="px-10 pb-10 pt-6">
        @if($application->rejection_reason)
        <div class="mb-5 rounded-2xl border border-rose-200 bg-rose-50 p-4 text-left">
            <p class="mb-1 text-xs font-extrabold uppercase tracking-wider text-rose-500">Alasan Penolakan</p>
            <p class="text-sm leading-relaxed text-rose-800">{{ $application->rejection_reason }}</p>
        </div>
        @endif
        <p class="text-sm text-slate-600 leading-relaxed">
            Kamu bisa mengajukan pendaftaran ulang setelah memperbaiki data yang diperlukan.
        </p>
        <div class="mt-5 flex flex-col gap-3">
            <a href="{{ route('merchant.apply.create') }}" class="btn-merchant w-full py-3.5 text-sm font-bold">
                Daftar Ulang
            </a>
            <a href="{{ route('products.index') }}" class="btn-secondary w-full py-3 text-sm">
                Kembali ke Marketplace
            </a>
        </div>
    </div>
</div>
@endif

</div>
</div>
@endsection
