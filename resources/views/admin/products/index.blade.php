@extends('layouts.app')

@section('title', 'GadgetHub - Admin Manajemen Produk')

@section('content')
<div class="flex flex-col gap-4">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold">Manajemen Produk</h1>
            <p class="text-gray-600">Kelola seluruh produk yang terdaftar di platform.</p>
        </div>
        <form action="{{ route('admin.products.index') }}" method="GET" class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul produk" class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <select name="status" class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Status</option>
                <option value="unsold" {{ request('status') == 'unsold' ? 'selected' : '' }}>Tersedia</option>
                <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>Terjual</option>
            </select>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Filter</button>
        </form>
    </div>

    <div class="overflow-x-auto bg-white rounded-xl shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penjual</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Tindakan</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($products as $product)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $product->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $product->title }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $product->user->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <span class="px-2 py-1 rounded-full text-white {{ $product->is_sold ? 'bg-red-600' : 'bg-green-600' }}">
                            {{ $product->is_sold ? 'Terjual' : 'Tersedia' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                        <a href="{{ route('products.show', $product) }}" class="text-blue-600 hover:text-blue-800">Lihat</a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 ml-4" onclick="return confirm('Yakin hapus produk ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada produk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        {{ $products->links() }}
    </div>
</div>
@endsection
