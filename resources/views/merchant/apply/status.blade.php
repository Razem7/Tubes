@extends('layouts.app')

@section('title', 'Status Pendaftaran Merchant - GadgetHub')

@section('content')
<div class="max-w-lg mx-auto px-4 py-16 text-center">

    @if(!$application)
        {{-- Belum pernah daftar --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-10">
            <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/><path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/></svg>
            </div>
            <h2 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Pendaftaran</h2>
            <p class="text-gray-500 text-sm mb-6">Kamu belum pernah mengajukan pendaftaran merchant.</p>
            <a href="{{ route('merchant.apply.create') }}"
               class="inline-block bg-purple-600 hover:bg-purple-700 text-white text-sm font-semibold px-6 py-3 rounded-xl transition">
                Daftar Sekarang
            </a>
        </div>

    @elseif($application->isPending())
        {{-- Menunggu review --}}
        <div class="bg-white rounded-2xl shadow-sm border border-yellow-200 p-10">
            <div class="w-16 h-16 bg-yellow-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
            </div>
            <span class="inline-block bg-yellow-100 text-yellow-700 text-xs font-bold px-3 py-1 rounded-full mb-3">Menunggu Review</span>
            <h2 class="text-xl font-bold text-gray-800 mb-2">Pendaftaran Sedang Diproses</h2>
            <p class="text-gray-500 text-sm mb-4">Pendaftaran untuk toko <strong>{{ $application->store_name }}</strong> sedang direview oleh tim GadgetHub.</p>
            <p class="text-xs text-gray-400">Dikirim {{ $application->created_at->diffForHumans() }} &middot; Proses 1–3 hari kerja</p>
        </div>

    @elseif($application->isApproved())
        @if(auth()->user()->isMerchant())
        {{-- Approved dan masih aktif merchant --}}
        <div class="bg-white rounded-2xl shadow-sm border border-green-200 p-10">
            <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            </div>
            <span class="inline-block bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full mb-3">Disetujui</span>
            <h2 class="text-xl font-bold text-gray-800 mb-2">Selamat! Kamu Sudah Jadi Merchant 🎉</h2>
            <p class="text-gray-500 text-sm mb-6">Toko <strong>{{ $application->store_name }}</strong> telah disetujui. Mulai upload produkmu sekarang!</p>
            <a href="{{ route('merchant.dashboard') }}"
               class="inline-block bg-purple-600 hover:bg-purple-700 text-white text-sm font-semibold px-6 py-3 rounded-xl transition">
                Masuk ke Dashboard Merchant
            </a>
        </div>
        @else
        {{-- Pernah approved tapi sudah di-demote admin ke user biasa --}}
        <div class="bg-white rounded-2xl shadow-sm border border-orange-200 p-10">
            <div class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-orange-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
            </div>
            <span class="inline-block bg-orange-100 text-orange-700 text-xs font-bold px-3 py-1 rounded-full mb-3">Akun Diubah</span>
            <h2 class="text-xl font-bold text-gray-800 mb-2">Status Merchant Dicabut</h2>
            <p class="text-gray-500 text-sm mb-2">Akun kamu telah diubah kembali menjadi <strong>User Biasa</strong> oleh Admin.</p>
            <p class="text-gray-500 text-sm mb-6">Kamu bisa mengajukan pendaftaran merchant ulang kapan saja.</p>
            <a href="{{ route('merchant.apply.create') }}"
               class="inline-block bg-purple-600 hover:bg-purple-700 text-white text-sm font-semibold px-6 py-3 rounded-xl transition">
                Daftar Merchant Lagi
            </a>
        </div>
        @endif

    @else
        {{-- Rejected --}}
        <div class="bg-white rounded-2xl shadow-sm border border-red-200 p-10">
            <div class="w-16 h-16 bg-red-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
            </div>
            <span class="inline-block bg-red-100 text-red-600 text-xs font-bold px-3 py-1 rounded-full mb-3">Ditolak</span>
            <h2 class="text-xl font-bold text-gray-800 mb-2">Pendaftaran Ditolak</h2>
            @if($application->rejection_reason)
            <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-5 text-left">
                <p class="text-xs font-semibold text-red-600 mb-1">Alasan Penolakan:</p>
                <p class="text-sm text-red-700">{{ $application->rejection_reason }}</p>
            </div>
            @endif
            <p class="text-gray-500 text-sm mb-6">Kamu bisa mengajukan pendaftaran ulang setelah memperbaiki data.</p>
            <a href="{{ route('merchant.apply.create') }}"
               class="inline-block bg-purple-600 hover:bg-purple-700 text-white text-sm font-semibold px-6 py-3 rounded-xl transition">
                Daftar Ulang
            </a>
        </div>
    @endif

</div>
@endsection
