@extends('layouts.merchant')

@section('title', 'Manajemen Stok - Merchant GadgetHub')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Manajemen Stok</h2>
    <p class="text-sm text-gray-500 mt-1">Update stok produk kamu</p>
</div>

<!-- Filter -->
<div class="bg-white rounded-xl shadow-sm p-4 mb-6">
    <form action="{{ route('merchant.stock') }}" method="GET" class="flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Cari produk..."
               class="flex-1 px-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
        <button type="submit" class="bg-purple-600 text-white px-5 py-2 rounded-lg text-sm hover:bg-purple-700">Cari</button>
        <a href="{{ route('merchant.stock') }}" class="bg-gray-200 text-gray-700 px-5 py-2 rounded-lg text-sm hover:bg-gray-300">Reset</a>
    </form>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Produk</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Harga</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Stok Saat Ini</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Update Stok</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <img src="{{ $product->photos->first() ? asset($product->photos->first()->photo_url) : 'https://via.placeholder.com/40' }}"
                                 class="w-10 h-10 rounded-lg object-cover flex-shrink-0">
                            <div>
                                <p class="text-sm font-medium text-gray-800">{{ Str::limit($product->title, 40) }}</p>
                                <p class="text-xs text-gray-400">{{ $product->category->name ?? '-' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-700">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        <span class="text-lg font-bold {{ ($product->stock ?? 0) <= 0 ? 'text-red-500' : 'text-gray-800' }}">
                            {{ $product->stock ?? 0 }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                            {{ $product->is_sold ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-700' }}">
                            {{ $product->is_sold ? 'Habis/Terjual' : 'Aktif' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <form action="{{ route('merchant.stock.update', $product) }}" method="POST" class="flex items-center gap-2">
                            @csrf @method('PATCH')
                            <input type="number" name="stock" value="{{ $product->stock ?? 0 }}" min="0"
                                   class="w-20 px-3 py-1.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <button type="submit" class="bg-purple-600 text-white text-xs px-3 py-1.5 rounded-lg hover:bg-purple-700 whitespace-nowrap">
                                Simpan
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-sm text-gray-400">Belum ada produk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">{{ $products->links() }}</div>
@endsection
