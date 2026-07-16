@extends('layouts.merchant')

@section('title', 'Data Penjualan - Merchant GadgetHub')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Data Penjualan</h2>
    <p class="text-sm text-gray-500 mt-1">Riwayat semua penjualan produkmu</p>
</div>

<!-- Summary -->
<div class="grid grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-blue-500">
        <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Total Transaksi</p>
        <p class="text-3xl font-bold text-blue-600 mt-1">{{ $summary['total'] }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-yellow-500">
        <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Menunggu</p>
        <p class="text-3xl font-bold text-yellow-600 mt-1">{{ $summary['pending'] }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-teal-500">
        <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Total Revenue</p>
        <p class="text-lg font-bold text-teal-600 mt-1">Rp {{ number_format($summary['revenue'], 0, ',', '.') }}</p>
    </div>
</div>

<!-- Filter -->
<div class="bg-white rounded-xl shadow-sm p-4 mb-6">
    <form action="{{ route('merchant.sales') }}" method="GET" class="flex gap-2">
        <select name="status" class="px-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
            <option value="">Semua Status</option>
            <option value="pending"   {{ request('status') === 'pending'   ? 'selected' : '' }}>Pending</option>
            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
        <button type="submit" class="bg-purple-600 text-white px-5 py-2 rounded-lg text-sm hover:bg-purple-700">Filter</button>
        <a href="{{ route('merchant.sales') }}" class="bg-gray-200 text-gray-700 px-5 py-2 rounded-lg text-sm hover:bg-gray-300">Reset</a>
    </form>
</div>

<!-- Table -->
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Produk</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Pembeli</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Harga</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Pembayaran</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($transactions as $trx)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <img src="{{ $trx->product->photos->first() ? asset($trx->product->photos->first()->photo_url) : 'https://via.placeholder.com/40' }}"
                                 class="w-10 h-10 rounded-lg object-cover flex-shrink-0">
                            <p class="text-sm font-medium text-gray-800">{{ Str::limit($trx->product->title, 35) }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-sm text-gray-800">{{ $trx->buyer->name }}</p>
                        <p class="text-xs text-gray-400">{{ $trx->buyer->phone_number ?? '-' }}</p>
                    </td>
                    <td class="px-6 py-4 text-sm font-semibold text-green-700">
                        Rp {{ number_format($trx->amount, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">
                        {{ strtoupper($trx->payment_method) }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                            {{ $trx->status === 'completed' ? 'bg-green-100 text-green-700' : ($trx->status === 'cancelled' ? 'bg-red-100 text-red-600' : 'bg-yellow-100 text-yellow-700') }}">
                            {{ ucfirst($trx->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ $trx->created_at->format('d/m/Y H:i') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-10 text-center text-sm text-gray-400">Belum ada penjualan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">{{ $transactions->links() }}</div>
@endsection
