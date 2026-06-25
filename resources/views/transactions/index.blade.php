@extends('layouts.app')

@section('title', 'Riwayat Transaksi - GadgetHub')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-8 mb-6">
        <h2 class="text-2xl font-bold">Riwayat Transaksi</h2>
        <p class="text-gray-600 mt-2">Lihat pesanan yang Anda beli atau jual.</p>
    </div>

    @if($transactions->count() > 0)
    <div class="grid gap-6">
        @foreach($transactions as $transaction)
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex flex-col lg:flex-row justify-between gap-4">
                <div>
                    <a href="{{ route('transactions.show', $transaction) }}" class="text-lg font-semibold text-blue-600 hover:underline">{{ $transaction->product->title }}</a>
                    <p class="text-sm text-gray-600 mt-1">{{ $transaction->seller->name === auth()->user()->name ? 'Anda sebagai penjual' : 'Anda sebagai pembeli' }}</p>
                </div>

                <div class="text-right text-sm text-gray-600">
                    <p>Status: <span class="font-semibold">{{ ucfirst($transaction->status) }}</span></p>
                    <p>Jumlah: Rp {{ number_format($transaction->amount, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $transactions->links() }}
    </div>
    @else
    <div class="bg-white rounded-lg shadow p-8 text-center">
        <p class="text-gray-600">Belum ada transaksi.</p>
    </div>
    @endif
</div>
@endsection
