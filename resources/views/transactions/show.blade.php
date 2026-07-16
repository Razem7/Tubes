@extends('layouts.app')

@section('title', 'GadgetHub - Detail Transaksi')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-8 mb-6">
        <h2 class="text-2xl font-bold mb-4">Detail Transaksi</h2>

        <div class="grid gap-6 lg:grid-cols-2">
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                <h3 class="font-semibold mb-3">Produk</h3>
                <img src="{{ $transaction->product->photos->first() && $transaction->product->photos->first()->photo_url ? asset($transaction->product->photos->first()->photo_url) : 'https://via.placeholder.com/400x300?text=No+Image' }}" alt="{{ $transaction->product->title }}" class="w-full h-64 object-cover rounded-lg mb-4">
                <p class="text-lg font-semibold">{{ $transaction->product->title }}</p>
                <p class="text-blue-600 text-2xl font-bold">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</p>
                <p class="text-sm text-gray-600 mt-2">{{ ucfirst(str_replace('_', ' ', $transaction->product->condition)) }} • {{ $transaction->product->location }}</p>
            </div>

            <div class="bg-white border border-gray-200 rounded-lg p-4">
                <h3 class="font-semibold mb-3">Informasi Transaksi</h3>
                <div class="space-y-3 text-sm text-gray-700">
                    <div class="flex justify-between"><span>Status</span><span class="font-medium">{{ ucfirst($transaction->status) }}</span></div>
                    <div class="flex justify-between"><span>Metode Pembayaran</span><span class="font-medium">{{ strtoupper($transaction->payment_method) }}</span></div>
                    <div class="flex justify-between"><span>Pembeli</span><span class="font-medium">{{ $transaction->buyer->name }}</span></div>
                    <div class="flex justify-between"><span>Penjual</span><span class="font-medium">{{ $transaction->seller->name }}</span></div>
                    @if($transaction->notes)
                    <div>
                        <span class="block font-medium">Catatan</span>
                        <p class="text-gray-700 mt-1">{{ $transaction->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('transactions.index') }}" class="inline-block bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300">Kembali ke Riwayat</a>
        </div>
    </div>
</div>
@endsection
