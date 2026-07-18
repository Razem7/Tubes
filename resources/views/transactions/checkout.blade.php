@extends('layouts.app')

@section('title', 'GadgetHub - Checkout')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-6">
    <div class="mb-5">
        <h2 class="text-2xl font-bold text-gray-800">Checkout</h2>
        <p class="text-sm text-gray-500 mt-0.5">Periksa detail produk dan isi alamat pengiriman</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

        {{-- Detail Produk --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h3 class="font-semibold text-gray-800 mb-4">Detail Produk</h3>
            @php $photo = $product->photos->first(); @endphp
            <div class="rounded-lg overflow-hidden bg-gray-100 mb-4" style="height:200px;">
                @if($photo && $photo->photo_url)
                    <img src="{{ asset($photo->photo_url) }}" alt="{{ $product->title }}"
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                @endif
            </div>
            <p class="font-semibold text-gray-800 mb-1">{{ $product->title }}</p>
            <p class="text-xl font-bold text-blue-600 mb-3">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            <div class="space-y-2 text-sm text-gray-600 border-t pt-3">
                <div class="flex justify-between">
                    <span class="text-gray-500">Kondisi</span>
                    <span class="font-medium">{{ ucfirst(str_replace('_', ' ', $product->condition)) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Lokasi</span>
                    <span class="font-medium">{{ $product->location }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Penjual</span>
                    <span class="font-medium">{{ $product->user->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Pembayaran</span>
                    <span class="font-semibold text-green-700">COD (Bayar di Tempat)</span>
                </div>
            </div>
        </div>

        {{-- Form Order --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h3 class="font-semibold text-gray-800 mb-4">Informasi Pengiriman</h3>

            <form action="{{ route('products.purchase', $product) }}" method="POST">
                @csrf

                {{-- Alamat Pengiriman --}}
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Alamat Pengiriman <span class="text-red-500">*</span>
                    </label>
                    @php $profileAddress = auth()->user()->address; @endphp
                    @if($profileAddress && !old('shipping_address'))
                        <div class="flex items-center gap-2 bg-blue-50 border border-blue-200 rounded-lg px-3 py-2 mb-2 text-xs text-blue-700">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z"/>
                            </svg>
                            Alamat diisi otomatis dari profil kamu.
                            <a href="{{ route('profile.edit') }}" class="underline font-semibold">Ubah di profil</a>
                        </div>
                    @endif
                    <textarea name="shipping_address" rows="4"
                              placeholder="Contoh: Jl. Mawar No. 12, RT 03/RW 05, Kel. Sukamaju, Kec. Cimahi Tengah, Kota Cimahi, Jawa Barat 40522"
                              class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 resize-none {{ $errors->has('shipping_address') ? 'border-red-400' : '' }}">{{ old('shipping_address', $profileAddress) }}</textarea>
                    @error('shipping_address')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-400 mt-1">Isi lengkap termasuk nama jalan, RT/RW, kelurahan, kecamatan, kota, dan kode pos.</p>
                </div>

                {{-- Catatan --}}
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Catatan untuk Penjual <span class="text-gray-400 font-normal">(opsional)</span>
                    </label>
                    <textarea name="notes" rows="3"
                              placeholder="Contoh: Mohon dikemas dengan bubble wrap..."
                              class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 resize-none">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Metode Pembayaran (fixed COD) --}}
                <div class="bg-green-50 border border-green-200 rounded-lg px-4 py-3 mb-5 flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <div>
                        <p class="text-sm font-semibold text-green-800">COD — Bayar di Tempat</p>
                        <p class="text-xs text-green-600">Bayar langsung saat barang tiba di tanganmu</p>
                    </div>
                </div>

                {{-- Ringkasan --}}
                <div class="border-t pt-4 mb-5">
                    <div class="flex justify-between text-sm text-gray-600 mb-1">
                        <span>Harga produk</span>
                        <span>Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between font-bold text-gray-800 text-base">
                        <span>Total</span>
                        <span class="text-blue-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    </div>
                </div>

                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition text-sm">
                    Buat Pesanan
                </button>
                <a href="{{ route('products.show', $product) }}"
                   class="block text-center text-sm text-gray-500 hover:text-gray-700 mt-3">
                    ← Kembali ke detail produk
                </a>
            </form>
        </div>

    </div>
</div>
@endsection
