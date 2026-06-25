@extends('layouts.app')

@section('title', $product->title . ' - GadgetHub')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Product Images -->
    <div>
        @if($product->photos->count() > 0)
        <div id="mainImage" class="mb-4">
            <img src="{{ $product->photos->first()->photo_url ? asset($product->photos->first()->photo_url) : 'https://via.placeholder.com/600x400?text=No+Image' }}" 
                 alt="{{ $product->title }}"
                 class="w-full h-96 object-cover rounded-lg">
        </div>
        <div class="grid grid-cols-4 gap-2">
            @foreach($product->photos as $photo)
            <img src="{{ $photo->photo_url ? asset($photo->photo_url) : 'https://via.placeholder.com/100x100?text=No+Image' }}" 
                 alt="{{ $product->title }}"
                 class="w-full h-20 object-cover rounded cursor-pointer hover:opacity-75"
                 onclick="changeMainImage('{{ $photo->photo_url ? asset($photo->photo_url) : 'https://via.placeholder.com/600x400?text=No+Image' }}')">
            @endforeach
        </div>
        @else
        <img src="https://via.placeholder.com/600x400?text=No+Image" 
             alt="{{ $product->title }}"
             class="w-full h-96 object-cover rounded-lg">
        @endif
    </div>

    <!-- Product Info -->
    <div>
        <h1 class="text-3xl font-bold mb-4">{{ $product->title }}</h1>
        
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
            <p class="text-3xl font-bold text-blue-600">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
        </div>

        <div class="bg-white rounded-lg shadow p-4 mb-4">
            <h3 class="font-semibold mb-3">Detail Produk</h3>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Kondisi:</span>
                    <span class="font-medium">{{ ucfirst(str_replace('_', ' ', $product->condition)) }}</span>
                </div>
                @if($product->brand)
                <div class="flex justify-between">
                    <span class="text-gray-600">Brand:</span>
                    <span class="font-medium">{{ $product->brand }}</span>
                </div>
                @endif
                @if($product->model)
                <div class="flex justify-between">
                    <span class="text-gray-600">Model:</span>
                    <span class="font-medium">{{ $product->model }}</span>
                </div>
                @endif
                @if($product->category)
                <div class="flex justify-between">
                    <span class="text-gray-600">Kategori:</span>
                    <span class="font-medium">{{ $product->category->name }}</span>
                </div>
                @endif
                <div class="flex justify-between">
                    <span class="text-gray-600">Lokasi:</span>
                    <span class="font-medium">{{ $product->location }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Metode Pembayaran:</span>
                    <span class="font-medium">
                        @foreach($product->getPaymentMethodsArray() as $method)
                            <span class="inline-block bg-gray-200 px-2 py-1 rounded text-xs mr-1">
                                {{ strtoupper($method) }}
                            </span>
                        @endforeach
                    </span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4 mb-4">
            <h3 class="font-semibold mb-3">Deskripsi</h3>
            <p class="text-gray-700 whitespace-pre-line">{{ $product->description }}</p>
        </div>

        <div class="bg-white rounded-lg shadow p-4 mb-4">
            <h3 class="font-semibold mb-3">Penjual</h3>
            <div class="flex items-center space-x-3">
                <img src="{{ $product->user->profile_photo_url ? asset('storage/' . $product->user->profile_photo_url) : 'https://ui-avatars.com/api/?name=' . urlencode($product->user->name) }}" 
                     alt="{{ $product->user->name }}"
                     class="w-12 h-12 rounded-full object-cover">
                <div>
                    <p class="font-medium">{{ $product->user->name }}</p>
                    @if($product->user->phone_verified)
                    <p class="text-sm text-green-600">✓ Nomor HP Terverifikasi</p>
                    @endif
                </div>
            </div>
        </div>

        @if($product->is_sold)
        <div class="mb-4">
            <span class="inline-flex items-center bg-red-100 text-red-700 px-3 py-2 rounded-full text-sm font-semibold">
                Produk ini sudah terjual
            </span>
        </div>
        @endif

        <!-- Action Buttons -->
        <div class="flex flex-col gap-2 md:flex-row">
            @auth
                @if($product->user_id === auth()->id())
                    <a href="{{ route('products.edit', $product) }}" class="flex-1 bg-blue-600 text-white text-center px-4 py-3 rounded-lg hover:bg-blue-700">
                        Edit Produk
                    </a>
                    <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white px-4 py-3 rounded-lg hover:bg-red-700">
                            Hapus
                        </button>
                    </form>
                @else
                    <a href="{{ route('products.checkout', $product) }}" class="flex-1 bg-green-600 text-white text-center px-4 py-3 rounded-lg hover:bg-green-700 {{ $product->is_sold ? 'opacity-50 cursor-not-allowed pointer-events-none' : '' }}">
                        Beli Sekarang
                    </a>
                    <form action="{{ route('chats.start', $product) }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-3 rounded-lg hover:bg-blue-700">
                            Chat Penjual
                        </button>
                    </form>
                    <form action="{{ route('favorites.toggle', $product) }}" method="POST" id="favoriteForm">
                        @csrf
                        <button type="submit" class="inline-flex items-center justify-center gap-2 bg-gray-200 text-gray-700 px-4 py-3 rounded-lg hover:bg-gray-300">
                            <span>{{ $isFavorited ? '❤️' : '🤍' }}</span>
                            <span>Favorit</span>
                        </button>
                    </form>
                @endif
            @else
                <a href="{{ route('login') }}" class="flex-1 bg-blue-600 text-white text-center px-4 py-3 rounded-lg hover:bg-blue-700">
                    Login untuk Chat
                </a>
            @endauth
        </div>
    </div>
</div>

@push('scripts')
<script>
function changeMainImage(src) {
    document.querySelector('#mainImage img').src = src;
}
</script>
@endpush
@endsection
