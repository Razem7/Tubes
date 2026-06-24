@extends('layouts.admin')

@section('title', 'Kelola Produk - Admin')

@section('content')
<div class="mb-6">
    <h2 class="text-3xl font-bold">Kelola Produk</h2>
</div>

<!-- Search -->
<div class="bg-white rounded-lg shadow p-4 mb-6">
    <form action="{{ route('admin.products') }}" method="GET" class="flex gap-2">
        <input type="text" 
               name="search" 
               value="{{ request('search') }}"
               placeholder="Cari produk..."
               class="flex-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
            Cari
        </button>
        <a href="{{ route('admin.products') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400">
            Reset
        </a>
    </form>
</div>

<!-- Products Table -->
<div class="bg-white rounded-lg shadow">
    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b">
                        <th class="text-left py-3">Foto</th>
                        <th class="text-left py-3">Judul</th>
                        <th class="text-left py-3">Harga</th>
                        <th class="text-left py-3">Penjual</th>
                        <th class="text-left py-3">Lokasi</th>
                        <th class="text-left py-3">Status</th>
                        <th class="text-left py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr class="border-b">
                        <td class="py-3">
                            <img src="{{ $product->photos->first() ? asset('storage/' . $product->photos->first()->photo_url) : 'https://via.placeholder.com/50' }}" 
                                 alt="{{ $product->title }}"
                                 class="w-16 h-16 object-cover rounded">
                        </td>
                        <td class="py-3">
                            <a href="{{ route('products.show', $product) }}" target="_blank" class="text-blue-600 hover:underline">
                                {{ $product->title }}
                            </a>
                        </td>
                        <td class="py-3">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="py-3">{{ $product->user->name }}</td>
                        <td class="py-3">{{ $product->location }}</td>
                        <td class="py-3">
                            @if($product->is_sold)
                            <span class="bg-red-100 text-red-600 px-2 py-1 rounded text-xs">Terjual</span>
                            @else
                            <span class="bg-green-100 text-green-600 px-2 py-1 rounded text-xs">Tersedia</span>
                            @endif
                        </td>
                        <td class="py-3">
                            <form action="{{ route('admin.products.delete', $product) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-sm">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-6 text-gray-500">
                            Tidak ada produk ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $products->links() }}
</div>
@endsection
