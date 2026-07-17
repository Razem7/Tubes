@extends('layouts.merchant')

@section('title', 'Data Penjualan - Merchant GadgetHub')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Data Penjualan</h2>
    <p class="text-sm text-gray-500 mt-1">Kelola dan konfirmasi pesanan dari pembeli</p>
</div>

{{-- Summary --}}
<div class="grid grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-blue-500">
        <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Total Transaksi</p>
        <p class="text-3xl font-bold text-blue-600 mt-1">{{ $summary['total'] }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-yellow-500">
        <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Menunggu Konfirmasi</p>
        <p class="text-3xl font-bold text-yellow-600 mt-1">{{ $summary['pending'] }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-teal-500">
        <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Total Revenue</p>
        <p class="text-lg font-bold text-teal-600 mt-1">Rp {{ number_format($summary['revenue'], 0, ',', '.') }}</p>
    </div>
</div>

{{-- Filter --}}
<div class="bg-white rounded-xl shadow-sm p-4 mb-6">
    <form action="{{ route('merchant.sales') }}" method="GET" class="flex gap-2 flex-wrap">
        <select name="status" class="px-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
            <option value="">Semua Status</option>
            <option value="pending"   {{ request('status') === 'pending'   ? 'selected' : '' }}>Menunggu Konfirmasi</option>
            <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
            <option value="rejected"  {{ request('status') === 'rejected'  ? 'selected' : '' }}>Ditolak</option>
            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
        </select>
        <button type="submit" class="bg-purple-600 text-white px-5 py-2 rounded-lg text-sm hover:bg-purple-700">Filter</button>
        <a href="{{ route('merchant.sales') }}" class="bg-gray-200 text-gray-700 px-5 py-2 rounded-lg text-sm hover:bg-gray-300">Reset</a>
    </form>
</div>

{{-- List Transaksi --}}
@forelse($transactions as $trx)
@php [$statusLabel, $statusClass] = $trx->statusBadge(); @endphp
<div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-3 overflow-hidden">
    <div class="flex items-start gap-4 p-4">
        {{-- Foto --}}
        <div class="w-14 h-14 rounded-lg bg-gray-100 flex-shrink-0 overflow-hidden">
            @php $p = $trx->product->photos->first(); @endphp
            @if($p && $p->photo_url)
                <img src="{{ asset($p->photo_url) }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
            @endif
        </div>

        {{-- Info --}}
        <div class="flex-1 min-w-0">
            <div class="flex items-start justify-between gap-2 flex-wrap">
                <p class="text-sm font-semibold text-gray-800 truncate">{{ Str::limit($trx->product->title, 45) }}</p>
                <span class="text-xs font-semibold px-2.5 py-1 rounded-full flex-shrink-0 {{ $statusClass }}">
                    {{ $statusLabel }}
                </span>
            </div>
            <p class="text-sm font-bold text-green-700 mt-0.5">Rp {{ number_format($trx->amount, 0, ',', '.') }}</p>
            <div class="flex flex-wrap gap-x-3 gap-y-0.5 mt-1">
                <span class="text-xs text-gray-500">Pembeli: <span class="font-medium text-gray-700">{{ $trx->buyer->name }}</span></span>
                <span class="text-xs text-gray-500">COD</span>
                <span class="text-xs text-gray-400">{{ $trx->created_at->format('d M Y, H:i') }}</span>
            </div>
            @if($trx->shipping_address)
            <p class="text-xs text-gray-500 mt-1 truncate">📍 {{ $trx->shipping_address }}</p>
            @endif
        </div>
    </div>

    {{-- Action bar --}}
    @if($trx->isPending())
    <div class="border-t px-4 py-3 bg-yellow-50 flex flex-wrap items-center justify-between gap-2">
        <p class="text-xs text-yellow-700 font-medium">⏳ Menunggu konfirmasimu</p>
        <div class="flex gap-2">
            <form action="{{ route('transactions.confirm', $trx) }}" method="POST">
                @csrf @method('PATCH')
                <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white text-xs font-semibold px-4 py-1.5 rounded-lg transition">
                    Konfirmasi
                </button>
            </form>
            <button onclick="openRejectModal({{ $trx->id }})"
                    class="bg-red-500 hover:bg-red-600 text-white text-xs font-semibold px-4 py-1.5 rounded-lg transition">
                Tolak
            </button>
            <a href="{{ route('transactions.show', $trx) }}"
               class="bg-white border hover:bg-gray-50 text-gray-700 text-xs font-semibold px-4 py-1.5 rounded-lg transition">
                Detail
            </a>
        </div>
    </div>
    @elseif($trx->isConfirmed())
    <div class="border-t px-4 py-3 bg-blue-50 flex flex-wrap items-center justify-between gap-2">
        <p class="text-xs text-blue-700 font-medium">📦 Dikonfirmasi — menunggu pembeli konfirmasi penerimaan barang</p>
        <a href="{{ route('transactions.show', $trx) }}"
           class="bg-white border hover:bg-gray-50 text-gray-700 text-xs font-semibold px-4 py-1.5 rounded-lg transition">
            Detail
        </a>
    </div>
    @else
    <div class="border-t px-4 py-2.5 flex justify-end">
        <a href="{{ route('transactions.show', $trx) }}"
           class="text-xs text-purple-600 hover:underline">Lihat Detail →</a>
    </div>
    @endif
</div>
@empty
<div class="bg-white rounded-xl border border-gray-200 py-14 text-center">
    <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
    </svg>
    <p class="text-gray-500 font-medium">Belum ada transaksi</p>
    <p class="text-xs text-gray-400 mt-1">Penjualan akan muncul di sini</p>
</div>
@endforelse

<div class="mt-4">{{ $transactions->links() }}</div>

{{-- Modal Tolak --}}
<div id="reject-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md">
        <div class="flex items-center justify-between px-5 py-4 border-b">
            <h3 class="font-semibold text-gray-800">Tolak Pesanan</h3>
            <button onclick="closeRejectModal()" class="text-gray-400 hover:text-gray-600 text-xl">&times;</button>
        </div>
        <form id="reject-form" method="POST" class="p-5">
            @csrf @method('PATCH')
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Alasan Penolakan <span class="text-gray-400 font-normal">(opsional)</span>
                </label>
                <textarea name="rejection_reason" rows="3" placeholder="Contoh: Stok habis, produk tidak tersedia..."
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-400 resize-none"></textarea>
            </div>
            <div class="flex gap-2">
                <button type="button" onclick="closeRejectModal()"
                        class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold py-2.5 rounded-lg">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold py-2.5 rounded-lg">
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
    document.getElementById('reject-modal').classList.remove('hidden');
}
function closeRejectModal() {
    document.getElementById('reject-modal').classList.add('hidden');
}
document.getElementById('reject-modal').addEventListener('click', function(e) {
    if (e.target === this) closeRejectModal();
});
</script>
@endpush

@endsection
