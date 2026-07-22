@extends('layouts.admin')
@section('title', 'Pendaftaran Merchant — Super Admin GadgetHub')

@section('content')

{{-- Header --}}
<div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <p class="section-eyebrow text-rose-600">Review</p>
        <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Pendaftaran Merchant</h1>
        <p class="mt-0.5 text-sm text-slate-500">Review dan setujui pendaftaran merchant baru</p>
    </div>
</div>

{{-- Summary Stats --}}
<div class="mb-7 grid grid-cols-3 gap-4">
    <div class="card p-5">
        <div class="mb-2 flex h-9 w-9 items-center justify-center rounded-xl bg-amber-50">
            <svg class="h-5 w-5 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <p class="stat-number text-amber-600">{{ $counts['pending'] }}</p>
        <p class="stat-label">Menunggu</p>
    </div>
    <div class="card p-5">
        <div class="mb-2 flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-50">
            <svg class="h-5 w-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <p class="stat-number text-emerald-600">{{ $counts['approved'] }}</p>
        <p class="stat-label">Disetujui</p>
    </div>
    <div class="card p-5">
        <div class="mb-2 flex h-9 w-9 items-center justify-center rounded-xl bg-rose-50">
            <svg class="h-5 w-5 text-rose-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <p class="stat-number text-rose-600">{{ $counts['rejected'] }}</p>
        <p class="stat-label">Ditolak</p>
    </div>
</div>

{{-- Filter --}}
<div class="card mb-6 p-4">
    <form action="{{ route('admin.merchant-applications.index') }}" method="GET"
          class="flex flex-wrap items-center gap-3">
        <select name="status" class="input-field w-auto min-w-[180px] py-2.5">
            <option value="">Semua Status</option>
            <option value="pending"  {{ request('status') === 'pending'  ? 'selected' : '' }}>Menunggu Review</option>
            <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui</option>
            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
        </select>
        <button type="submit"
                class="inline-flex items-center gap-2 rounded-2xl bg-rose-600 px-5 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-rose-700 active:scale-95">
            Filter
        </button>
        @if(request('status'))
        <a href="{{ route('admin.merchant-applications.index') }}" class="btn-secondary py-2.5 px-4 text-sm">Reset</a>
        @endif
    </form>
</div>

{{-- Table --}}
<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th class="pl-5">Pemohon</th>
                    <th>Nama Toko</th>
                    <th class="hidden sm:table-cell">Jenis Produk</th>
                    <th>Status</th>
                    <th class="hidden md:table-cell">Tanggal</th>
                    <th class="pr-5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $app)
                @php
                    $statusConfig = [
                        'pending'  => ['class' => 'bg-amber-100 text-amber-700',   'dot' => 'bg-amber-400'],
                        'approved' => ['class' => 'bg-emerald-100 text-emerald-700','dot' => 'bg-emerald-500'],
                        'rejected' => ['class' => 'bg-rose-100 text-rose-700',     'dot' => 'bg-rose-500'],
                    ];
                    $sc = $statusConfig[$app->status] ?? $statusConfig['pending'];
                @endphp
                <tr>
                    {{-- Applicant --}}
                    <td class="pl-5">
                        <div class="flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($app->user->name) }}&background=4f46e5&color=fff&size=64"
                                 class="avatar avatar-sm flex-shrink-0">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-semibold text-slate-800">{{ $app->user->name }}</p>
                                <p class="truncate text-xs text-slate-400">{{ $app->user->email }}</p>
                            </div>
                        </div>
                    </td>

                    {{-- Store name --}}
                    <td class="text-sm font-semibold text-slate-800">{{ $app->store_name }}</td>

                    {{-- Category --}}
                    <td class="hidden sm:table-cell text-sm text-slate-500">{{ $app->store_category }}</td>

                    {{-- Status badge --}}
                    <td>
                        <span class="inline-flex items-center gap-1.5 rounded-xl px-2.5 py-1 text-xs font-semibold {{ $sc['class'] }}">
                            <span class="h-1.5 w-1.5 rounded-full {{ $sc['dot'] }}"></span>
                            {{ $app->statusLabel() }}
                        </span>
                    </td>

                    {{-- Date --}}
                    <td class="hidden md:table-cell whitespace-nowrap text-sm text-slate-400">
                        {{ $app->created_at->format('d/m/Y') }}
                    </td>

                    {{-- Action --}}
                    <td class="pr-5 text-right">
                        <a href="{{ route('admin.merchant-applications.show', $app) }}"
                           class="inline-flex items-center gap-1.5 rounded-xl border border-brand-200 bg-brand-50 px-3.5 py-1.5 text-xs font-semibold text-brand-700 transition-colors hover:bg-brand-100 active:scale-95">
                            Detail
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-16 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100">
                                <svg class="h-6 w-6 text-slate-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                                    <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <p class="text-sm font-semibold text-slate-500">
                                {{ request('status') ? 'Tidak ada pendaftaran' : 'Belum ada pendaftaran merchant' }}
                            </p>
                            @if(request('status'))
                            <a href="{{ route('admin.merchant-applications.index') }}"
                               class="text-xs font-semibold text-rose-600 hover:underline">Reset filter</a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($applications->hasPages())
<div class="mt-6 flex justify-center border-t border-slate-100 pt-6">
    {{ $applications->withQueryString()->links() }}
</div>
@endif

@endsection
