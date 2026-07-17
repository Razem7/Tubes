@extends('layouts.app')

@section('title', 'GadgetHub - Detail Transaksi')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-6">

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('transactions.index') }}"
           class="text-gray-400 hover:text-gray-600 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h2 class="text-xl font-bold text-gray-800">Detail Transaksi</h2>
            <p class="text-xs text-gray-400">#{{ $transaction->id }} · {{ $transaction->created_at->format('d M Y, H:i') }}</p>
        </div>
    </div>

    @php
        [$statusLabel, $statusClass] = $transaction->statusBadge();
        $isBuyer  = $transaction->buyer_id  === auth()->id();
        $isSeller = $transaction->seller_id === auth()->id();
    @endphp

    {{-- Status Banner --}}
    <div class="rounded-xl px-5 py-4 mb-5 flex items-center gap-3 {{ $statusClass }} border {{ $transaction->isPending() ? 'border-yellow-200' : ($transaction->isConfirmed() ? 'border-blue-200' : ($transaction->isCompleted() ? 'border-green-200' : ($transaction->isRejected() ? 'border-red-200' : 'border-gray-200'))) }}">
        <div class="text-2xl">
            @if($transaction->isPending()) ⏳
            @elseif($transaction->isConfirmed()) ✅
            @elseif($transaction->isCompleted()) 🎉
            @elseif($transaction->isRejected()) ❌
            @else 🚫
            @endif
        </div>
        <div>
            <p class="font-semibold text-sm">{{ $statusLabel }}</p>
            <p class="text-xs opacity-75">
                @if($transaction->isPending())
                    {{ $isBuyer ? 'Menunggu konfirmasi dari penjual.' : 'Ada pesanan baru yang menunggu konfirmasimu.' }}
                @elseif($transaction->isConfirmed())
                    {{ $isBuyer ? 'Penjual telah mengkonfirmasi pesananmu. Segera konfirmasi jika barang sudah diterima.' : 'Pesanan dikonfirmasi — menunggu pembeli konfirmasi penerimaan barang.' }}
                @elseif($transaction->isCompleted())
                    Transaksi selesai — pembeli telah mengkonfirmasi penerimaan barang.
                @elseif($transaction->isRejected())
                    Ditolak pada {{ $transaction->rejected_at?->format('d M Y') }}.
                @else
                    Transaksi dibatalkan.
                @endif
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

        {{-- Produk --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h3 class="font-semibold text-gray-700 mb-3 text-sm uppercase tracking-wide">Produk</h3>
            @php $photo = $transaction->product->photos->first(); @endphp
            <div class="rounded-lg overflow-hidden bg-gray-100 mb-3" style="height:160px;">
                @if($photo && $photo->photo_url)
                    <img src="{{ asset($photo->photo_url) }}" alt="{{ $transaction->product->title }}"
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                @endif
            </div>
            <p class="font-semibold text-gray-800 text-sm mb-0.5">{{ $transaction->product->title }}</p>
            <p class="text-lg font-bold text-blue-600">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</p>
        </div>

        {{-- Info Transaksi --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h3 class="font-semibold text-gray-700 mb-3 text-sm uppercase tracking-wide">Info Transaksi</h3>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between gap-2">
                    <span class="text-gray-500">Pembeli</span>
                    <span class="font-medium text-gray-800">{{ $transaction->buyer->name }}</span>
                </div>
                <div class="flex justify-between gap-2">
                    <span class="text-gray-500">Penjual</span>
                    <span class="font-medium text-gray-800">{{ $transaction->seller->name }}</span>
                </div>
                <div class="flex justify-between gap-2">
                    <span class="text-gray-500">Pembayaran</span>
                    <span class="font-semibold text-green-700">COD (Bayar di Tempat)</span>
                </div>
                <div class="flex justify-between gap-2">
                    <span class="text-gray-500">Total</span>
                    <span class="font-bold text-blue-600">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                </div>
                @if($transaction->confirmed_at)
                <div class="flex justify-between gap-2">
                    <span class="text-gray-500">Dikonfirmasi</span>
                    <span class="font-medium text-gray-800">{{ $transaction->confirmed_at->format('d M Y, H:i') }}</span>
                </div>
                @endif
            </div>

            {{-- Alamat Pengiriman --}}
            @if($transaction->shipping_address)
            <div class="mt-4 pt-4 border-t">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Alamat Pengiriman</p>
                <p class="text-sm text-gray-700 leading-relaxed">{{ $transaction->shipping_address }}</p>
            </div>
            @endif

            {{-- Catatan --}}
            @if($transaction->notes)
            <div class="mt-3 pt-3 border-t">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Catatan</p>
                <p class="text-sm text-gray-700">{{ $transaction->notes }}</p>
            </div>
            @endif

            {{-- Alasan Penolakan --}}
            @if($transaction->isRejected() && $transaction->rejection_reason)
            <div class="mt-3 pt-3 border-t">
                <p class="text-xs font-semibold text-red-500 uppercase tracking-wide mb-1.5">Alasan Penolakan</p>
                <p class="text-sm text-red-700">{{ $transaction->rejection_reason }}</p>
            </div>
            @endif
        </div>

    </div>

    {{-- Tombol Aksi --}}
    <div class="mt-5 bg-white rounded-xl border border-gray-200 p-5">
        @if($isSeller && $transaction->isPending())
            <p class="text-sm font-semibold text-gray-700 mb-3">Tindakan Penjual</p>
            <div class="flex flex-wrap gap-3">
                <form action="{{ route('transactions.confirm', $transaction) }}" method="POST">
                    @csrf @method('PATCH')
                    <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition">
                        ✓ Konfirmasi Pesanan
                    </button>
                </form>
                <button onclick="openRejectModal({{ $transaction->id }})"
                        class="bg-red-500 hover:bg-red-600 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition">
                    ✕ Tolak Pesanan
                </button>
            </div>

        @elseif($isSeller && $transaction->isConfirmed())
            <div class="flex items-center gap-3 text-blue-700 bg-blue-50 rounded-lg px-4 py-3">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-sm font-medium">Menunggu pembeli mengkonfirmasi penerimaan barang.</p>
            </div>

        @elseif($isBuyer && $transaction->isPending())
            <p class="text-sm font-semibold text-gray-700 mb-3">Tindakan Pembeli</p>
            <form action="{{ route('transactions.cancel', $transaction) }}" method="POST"
                  onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                @csrf @method('PATCH')
                <button type="submit"
                        class="bg-gray-400 hover:bg-gray-500 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition">
                    Batalkan Pesanan
                </button>
            </form>

        @elseif($isBuyer && $transaction->isConfirmed())
            <p class="text-sm font-semibold text-gray-700 mb-3">Konfirmasi Penerimaan</p>
            <p class="text-sm text-gray-500 mb-4">Penjual sudah mengkonfirmasi pesananmu. Klik tombol di bawah jika barang sudah kamu terima.</p>
            <form action="{{ route('transactions.receive', $transaction) }}" method="POST"
                  onsubmit="return confirm('Konfirmasi bahwa barang sudah kamu terima? Transaksi akan otomatis selesai.')">
                @csrf @method('PATCH')
                <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition">
                    📦 Konfirmasi Barang Diterima
                </button>
            </form>

        @else
            <a href="{{ route('transactions.index') }}"
               class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700">
                ← Kembali ke Riwayat Transaksi
            </a>
        @endif
    </div>

</div>

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
                <textarea name="rejection_reason" rows="3" placeholder="Contoh: Stok habis..."
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
