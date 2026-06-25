@extends('layouts.app')

@section('title', 'Checkout - GadgetHub')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-bold mb-6">Checkout</h2>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                <h3 class="font-semibold mb-4">Detail Produk</h3>
                <img src="{{ $product->photos->first() ? asset('storage/' . $product->photos->first()->photo_url) : 'https://via.placeholder.com/400x300?text=No+Image' }}" alt="{{ $product->title }}" class="w-full h-64 object-cover rounded-lg mb-4">
                <p class="font-semibold text-lg mb-2">{{ $product->title }}</p>
                <p class="text-blue-600 text-2xl font-bold mb-4">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                <div class="space-y-2 text-sm text-gray-700">
                    <div class="flex justify-between"><span>Kondisi:</span><span>{{ ucfirst(str_replace('_', ' ', $product->condition)) }}</span></div>
                    <div class="flex justify-between"><span>Lokasi:</span><span>{{ $product->location }}</span></div>
                    <div class="flex justify-between"><span>Penjual:</span><span>{{ $product->user->name }}</span></div>
                    <div class="flex justify-between"><span>Metode tersedia:</span><span>{{ implode(', ', array_map(fn($method) => strtoupper($method), $product->getPaymentMethodsArray())) }}</span></div>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-lg p-4">
                <h3 class="font-semibold mb-4">Pilih Metode Pembayaran</h3>

                <form action="{{ route('products.purchase', $product) }}" method="POST">
                    @csrf

                    <div class="space-y-4">
                        @foreach($product->getPaymentMethodsArray() as $method)
                        <label class="flex items-center gap-3 p-3 border rounded-lg hover:border-blue-500 cursor-pointer">
                            <input type="radio" name="payment_method" value="{{ $method }}" class="form-radio" {{ old('payment_method') === $method ? 'checked' : '' }} required>
                            <span class="font-medium">{{ $method === 'cod' ? 'COD (Cash on Delivery)' : 'Rekber (Rekening Bersama)' }}</span>
                        </label>
                        @endforeach

                        @error('payment_method')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror

                        <div>
                            <label for="notes" class="block text-gray-700 mb-2">Catatan untuk penjual (opsional)</label>
                            <textarea id="notes" name="notes" rows="4" class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('notes') }}</textarea>
                            @error('notes')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700">Bayar Sekarang</button>
                        <a href="{{ route('products.show', $product) }}" class="block text-center text-gray-700 mt-3">Kembali ke detail produk</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
