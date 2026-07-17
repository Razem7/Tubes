@extends('layouts.app')

@section('title', 'GadgetHub - Riwayat Transaksi')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">

    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Riwayat Transaksi</h2>
        <p class="text-sm text-gray-500 mt-0.5">Semua transaksi sebagai pembeli maupun penjual</p>
    </div>

    @if($transactions->count() > 0)
    <div class="space-y-4">
        @foreach($transactions as $trx)
        @php
            [$statusLabel, $statusClass] = $trx->statusBadge();
            $isBuyer  = $trx->buyer_id  === auth()->id();
            $isSeller = $trx->seller_id === auth()->id();
            $photo    = $trx->product->photos->first();
        @endphp
        <div class="bg-white rounded-xl border border-gray-200 hover:shadow-sm transition overflow-hidden">
            <div class="flex items-start gap-4 p-4">

                {{-- Foto produk --}}
                <div class="w-16 h-16 rounded-lg bg-gray-100 flex-shrink-0 overflow-hidden">
                    @if($photo && $photo->photo_url)
                        <img src="{{ asset($photo->photo_url) }}" alt="{{ $trx->product->title }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    @endif
                </div>

                {{-- Info --}}
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-2 flex-wrap">
                        <a href="{{ route('transactions.show', $trx) }}"
                           class="text-sm font-semibold text-gray-800 hover:text-blue-600 truncate transition">
                            {{ $trx->product->title }}
                        </a>
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full flex-shrink-0 {{ $statusClass }}">
                            {{ $statusLabel }}
                        </span>
                    </div>
                    <p class="text-sm font-bold text-blue-600 mt-0.5">
                        Rp {{ number_format($trx->amount, 0, ',', '.') }}
                    </p>
                    <div class="flex items-center gap-3 mt-1 flex-wrap">
                        <span class="text-xs text-gray-400">
                            {{ $isBuyer ? '🛒 Kamu sebagai pembeli' : '🏪 Kamu sebagai penjual' }}
                        </span>
                        <span class="text-xs text-gray-400">
                            {{ $trx->created_at->format('d M Y, H:i') }}
                        </span>
                        <span class="text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded">COD</span>
                    </div>
                </div>
            </div>

            {{-- Tombol aksi --}}
            @php $showActions = false; @endphp
            @if($isSeller && $trx->isPending())
                @php $showActions = true; @endphp
                <div class="border-t px-4 py-3 bg-yellow-50 flex flex-wrap items-center justify-between gap-2">
                    <p class="text-xs text-yellow-700 font-medium">⏳ Pembeli menunggu konfirmasimu</p>
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
                           class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold px-4 py-1.5 rounded-lg transition">
                            Detail
                        </a>
                    </div>
                </div>
            @elseif($isSeller && $trx->isConfirmed())
                @php $showActions = true; @endphp
                <div class="border-t px-4 py-3 bg-blue-50 flex flex-wrap items-center justify-between gap-2">
                    <p class="text-xs text-blue-700 font-medium">✅ Pesanan dikonfirmasi — menunggu pembeli konfirmasi penerimaan</p>
                    <a href="{{ route('transactions.show', $trx) }}"
                       class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold px-4 py-1.5 rounded-lg transition">
                        Detail
                    </a>
                </div>
            @elseif($isBuyer && $trx->isPending())
                @php $showActions = true; @endphp
                <div class="border-t px-4 py-3 bg-yellow-50 flex flex-wrap items-center justify-between gap-2">
                    <p class="text-xs text-yellow-700 font-medium">⏳ Menunggu konfirmasi dari penjual</p>
                    <div class="flex gap-2">
                        <form action="{{ route('transactions.cancel', $trx) }}" method="POST"
                              onsubmit="return confirm('Batalkan pesanan ini?')">
                            @csrf @method('PATCH')
                            <button type="submit"
                                    class="bg-gray-400 hover:bg-gray-500 text-white text-xs font-semibold px-4 py-1.5 rounded-lg transition">
                                Batalkan
                            </button>
                        </form>
                        <a href="{{ route('transactions.show', $trx) }}"
                           class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold px-4 py-1.5 rounded-lg transition">
                            Detail
                        </a>
                    </div>
                </div>
            @elseif($isBuyer && $trx->isConfirmed())
                @php $showActions = true; @endphp
                <div class="border-t px-4 py-3 bg-green-50 flex flex-wrap items-center justify-between gap-2">
                    <p class="text-xs text-green-700 font-medium">📦 Penjual telah mengkonfirmasi — sudah terima barangnya?</p>
                    <div class="flex gap-2">
                        <form action="{{ route('transactions.receive', $trx) }}" method="POST"
                              onsubmit="return confirm('Konfirmasi bahwa barang sudah kamu terima?')">
                            @csrf @method('PATCH')
                            <button type="submit"
                                    class="bg-green-600 hover:bg-green-700 text-white text-xs font-semibold px-4 py-1.5 rounded-lg transition">
                                ✓ Barang Diterima
                            </button>
                        </form>
                        <a href="{{ route('transactions.show', $trx) }}"
                           class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold px-4 py-1.5 rounded-lg transition">
                            Detail
                        </a>
                    </div>
                </div>
            @endif

            @if(!$showActions)
            <div class="border-t px-4 py-2.5 flex justify-end">
                <a href="{{ route('transactions.show', $trx) }}"
                   class="text-xs text-blue-600 hover:underline">Lihat Detail →</a>
            </div>
            @endif
        </div>
        @endforeach
    </div>

    <div class="mt-6">{{ $transactions->links() }}</div>

    @else
    <div class="bg-white rounded-xl border border-gray-200 py-16 text-center">
        <svg class="w-14 h-14 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
        <p class="text-gray-600 font-medium">Belum ada transaksi</p>
        <p class="text-sm text-gray-400 mt-1">Transaksimu akan muncul di sini</p>
    </div>
    @endif

</div>

{{-- Modal Tolak --}}
<div id="reject-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md">
        <div class="flex items-center justify-between px-5 py-4 border-b">
            <h3 class="font-semibold text-gray-800">Tolak Pesanan</h3>
            <button onclick="closeRejectModal()" class="text-gray-400 hover:text-gray-600 text-xl leading-none">&times;</button>
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
