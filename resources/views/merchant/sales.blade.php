@extends('layouts.merchant')
@section('title', 'Data Penjualan — Merchant GadgetHub')

@section('content')

{{-- Header --}}
<div class="mb-7">
    <p class="section-eyebrow">Penjualan</p>
    <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Data Penjualan</h1>
    <p class="mt-0.5 text-sm text-slate-500">Kelola dan konfirmasi pesanan dari pembeli</p>
</div>

{{-- Summary Stats --}}
<div class="mb-7 grid grid-cols-1 gap-4 sm:grid-cols-3">
    <div class="card p-5">
        <div class="mb-2 flex h-9 w-9 items-center justify-center rounded-xl bg-brand-50">
            <svg class="h-5 w-5 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
            </svg>
        </div>
        <p class="stat-number">{{ $summary['total'] }}</p>
        <p class="stat-label">Total Transaksi</p>
    </div>
    <div class="card p-5">
        <div class="mb-2 flex h-9 w-9 items-center justify-center rounded-xl bg-amber-50">
            <svg class="h-5 w-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <p class="stat-number text-amber-600">{{ $summary['pending'] }}</p>
        <p class="stat-label">Menunggu Konfirmasi</p>
    </div>
    <div class="card p-5">
        <div class="mb-2 flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-50">
            <svg class="h-5 w-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1"/>
            </svg>
        </div>
        <p class="text-lg font-extrabold text-slate-900">Rp {{ number_format($summary['revenue'], 0, ',', '.') }}</p>
        <p class="stat-label">Total Revenue</p>
    </div>
</div>

{{-- Filter --}}
<div class="card mb-6 p-4">
    <form action="{{ route('merchant.sales') }}" method="GET"
          class="flex flex-wrap items-center gap-3">
        <select name="status" class="input-field w-auto min-w-[200px] py-2.5">
            <option value="">Semua Status</option>
            <option value="pending"   {{ request('status') === 'pending'   ? 'selected' : '' }}>Menunggu Konfirmasi</option>
            <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
            <option value="rejected"  {{ request('status') === 'rejected'  ? 'selected' : '' }}>Ditolak</option>
            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
        </select>
        <button type="submit" class="btn-merchant py-2.5 px-5 text-sm">Filter</button>
        @if(request('status'))
        <a href="{{ route('merchant.sales') }}" class="btn-secondary py-2.5 px-4 text-sm">Reset</a>
        @endif
    </form>
</div>

{{-- Transaction Cards --}}
<div class="space-y-4">
@forelse($transactions as $trx)
@php
    [$statusLabel, $statusClass] = $trx->statusBadge();
    $photo = $trx->product->photos->first();
@endphp

<div class="card overflow-hidden transition-all duration-200 hover:shadow-card-hover">

    {{-- Main row --}}
    <div class="flex items-start gap-4 p-5">

        {{-- Product thumbnail --}}
        <div class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-2xl bg-slate-100">
            @if($photo && $photo->photo_url)
                <img src="{{ $photo->photo_url }}" class="h-full w-full object-cover"
                     onerror="this.style.display='none'">
            @else
                <div class="flex h-full w-full items-center justify-center text-slate-300">
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            @endif
        </div>

        {{-- Info --}}
        <div class="min-w-0 flex-1">
            <div class="flex flex-wrap items-start justify-between gap-2">
                <p class="text-sm font-bold text-slate-900">
                    {{ Str::limit($trx->product->title, 50) }}
                </p>
                <span class="badge {{ $statusClass }} flex-shrink-0">{{ $statusLabel }}</span>
            </div>
            <p class="mt-1 text-base font-extrabold text-emerald-600">
                Rp {{ number_format($trx->amount, 0, ',', '.') }}
            </p>
            <div class="mt-1.5 flex flex-wrap items-center gap-x-3 gap-y-0.5 text-xs text-slate-400">
                <span>Pembeli: <span class="font-semibold text-slate-600">{{ $trx->buyer->name }}</span></span>
                <span class="text-slate-200">·</span>
                <span>COD</span>
                <span class="text-slate-200">·</span>
                <span>{{ $trx->created_at->format('d M Y, H:i') }}</span>
            </div>
            @if($trx->shipping_address)
            <p class="mt-1 flex items-center gap-1 text-xs text-slate-400 truncate">
                <svg class="h-3.5 w-3.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                </svg>
                {{ $trx->shipping_address }}
            </p>
            @endif
        </div>
    </div>

    {{-- Action bar --}}
    @if($trx->isPending())
    <div class="flex flex-wrap items-center justify-between gap-3 border-t border-amber-100 bg-amber-50/60 px-5 py-3.5">
        <div class="flex items-center gap-2 text-xs font-semibold text-amber-700">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Menunggu konfirmasimu
        </div>
        <div class="flex flex-wrap gap-2">
            <form action="{{ route('transactions.confirm', $trx) }}" method="POST">
                @csrf @method('PATCH')
                <button type="submit"
                        class="inline-flex items-center gap-1.5 rounded-xl bg-emerald-600 px-4 py-2 text-xs font-bold text-white transition-colors hover:bg-emerald-700 active:scale-95">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Konfirmasi
                </button>
            </form>
            <button type="button" onclick="openRejectModal({{ $trx->id }})"
                    class="inline-flex items-center gap-1.5 rounded-xl bg-rose-600 px-4 py-2 text-xs font-bold text-white transition-colors hover:bg-rose-700 active:scale-95">
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Tolak
            </button>
            <a href="{{ route('transactions.show', $trx) }}"
               class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-4 py-2 text-xs font-semibold text-slate-700 transition-colors hover:bg-slate-50">
                Detail
            </a>
        </div>
    </div>

    @elseif($trx->isConfirmed())
    <div class="flex flex-wrap items-center justify-between gap-3 border-t border-brand-100 bg-brand-50/50 px-5 py-3.5">
        <div class="flex items-center gap-2 text-xs font-semibold text-brand-700">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
            </svg>
            Dikonfirmasi — menunggu pembeli konfirmasi penerimaan
        </div>
        <a href="{{ route('transactions.show', $trx) }}"
           class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-xs font-semibold text-slate-700 transition-colors hover:bg-slate-50">
            Lihat Detail
        </a>
    </div>

    @else
    <div class="flex justify-end border-t border-slate-100 px-5 py-3">
        <a href="{{ route('transactions.show', $trx) }}"
           class="text-xs font-semibold text-purple-600 transition-colors hover:text-purple-800">
            Lihat Detail →
        </a>
    </div>
    @endif

</div>
@empty

<div class="empty-state py-20">
    <div class="empty-state-icon bg-slate-100 text-slate-400">
        <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
    </div>
    <h3 class="empty-state-title">
        {{ request('status') ? 'Tidak ada transaksi' : 'Belum ada penjualan' }}
    </h3>
    <p class="empty-state-desc">
        {{ request('status') ? 'Coba ubah filter status yang kamu pilih.' : 'Penjualan dari pembeli akan muncul di sini.' }}
    </p>
    @if(request('status'))
    <a href="{{ route('merchant.sales') }}" class="btn-secondary mt-5 py-2.5 px-5 text-sm">Reset Filter</a>
    @endif
</div>

@endforelse
</div>

@if($transactions->hasPages())
<div class="mt-6 flex justify-center border-t border-slate-100 pt-6">
    {{ $transactions->withQueryString()->links() }}
</div>
@endif

{{-- ── Reject Modal ── --}}
<div id="reject-modal"
     class="fixed inset-0 z-[100] hidden items-center justify-center bg-slate-900/60 p-4 backdrop-blur-sm">
    <div class="w-full max-w-md animate-scale-in rounded-4xl border border-slate-200/60 bg-white p-6 shadow-modal">
        <div class="mb-5 flex items-center justify-between">
            <h3 class="text-base font-bold text-slate-900">Tolak Pesanan</h3>
            <button type="button" onclick="closeRejectModal()"
                    class="flex h-8 w-8 items-center justify-center rounded-xl text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition-colors">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form id="reject-form" method="POST">
            @csrf @method('PATCH')
            <div class="form-group mb-5">
                <label class="input-label" for="rejection_reason">
                    Alasan Penolakan
                    <span class="font-normal text-slate-400">(opsional)</span>
                </label>
                <textarea id="rejection_reason" name="rejection_reason" rows="3"
                          placeholder="Contoh: Stok habis, produk tidak tersedia saat ini…"
                          class="input-field resize-none"></textarea>
            </div>
            <div class="flex gap-2.5">
                <button type="button" onclick="closeRejectModal()"
                        class="btn-secondary flex-1 py-3 text-sm">
                    Batal
                </button>
                <button type="submit"
                        class="btn-danger flex-1 py-3 text-sm">
                    Tolak Pesanan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openRejectModal(id) {
    document.getElementById('reject-form').action = `/transactions/${id}/reject`;
    const modal = document.getElementById('reject-modal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}
function closeRejectModal() {
    const modal = document.getElementById('reject-modal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
document.getElementById('reject-modal').addEventListener('click', function(e) {
    if (e.target === this) closeRejectModal();
});
</script>
@endpush

@endsection
