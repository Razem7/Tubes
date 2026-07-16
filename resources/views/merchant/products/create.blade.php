@extends('layouts.merchant')

@section('title', 'Tambah Produk - Merchant GadgetHub')

@section('content')
<div class="mb-6">
    <a href="{{ route('merchant.products') }}" class="text-sm text-gray-500 hover:text-purple-600 flex items-center gap-1 mb-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali ke Produk
    </a>
    <h2 class="text-2xl font-bold text-gray-800">Tambah Produk Baru</h2>
</div>

<form action="{{ route('merchant.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-5">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Informasi Produk</h3>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" required
                           class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 @error('title') border-red-400 @enderror"
                           placeholder="Contoh: iPhone 13 Pro Max 256GB">
                    @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi <span class="text-red-500">*</span></label>
                    <textarea name="description" rows="5" required
                              class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 @error('description') border-red-400 @enderror"
                              placeholder="Deskripsikan kondisi, spesifikasi, dan kelengkapan produk...">{{ old('description') }}</textarea>
                    @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" name="price" value="{{ old('price') }}" required min="1"
                               class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 @error('price') border-red-400 @enderror"
                               placeholder="1500000">
                        @error('price')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Stok <span class="text-red-500">*</span></label>
                        <input type="number" name="stock" value="{{ old('stock', 1) }}" required min="1"
                               class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 @error('stock') border-red-400 @enderror">
                        @error('stock')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <!-- Detail -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Detail Produk</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                        <select name="category_id" required
                                class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 @error('category_id') border-red-400 @enderror">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kondisi <span class="text-red-500">*</span></label>
                        <select name="condition" required
                                class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <option value="">Pilih Kondisi</option>
                            <option value="new"      {{ old('condition') === 'new'      ? 'selected' : '' }}>Baru</option>
                            <option value="like_new" {{ old('condition') === 'like_new' ? 'selected' : '' }}>Seperti Baru</option>
                            <option value="good"     {{ old('condition') === 'good'     ? 'selected' : '' }}>Baik</option>
                            <option value="fair"     {{ old('condition') === 'fair'     ? 'selected' : '' }}>Cukup</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Brand</label>
                        <input type="text" name="brand" value="{{ old('brand') }}"
                               class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500"
                               placeholder="Apple, Samsung, dll">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Model</label>
                        <input type="text" name="model" value="{{ old('model') }}"
                               class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500"
                               placeholder="iPhone 13, Galaxy S22, dll">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi <span class="text-red-500">*</span></label>
                        <input type="text" name="location" value="{{ old('location') }}" required
                               class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500"
                               placeholder="Jakarta Selatan">
                    </div>
                </div>
            </div>

            <!-- Foto -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Foto Produk <span class="text-gray-400 font-normal text-sm">(maks. 5 foto)</span></h3>
                <input type="file" name="photos[]" multiple accept="image/*"
                       class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                @error('photos.*')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-5">
            <!-- Payment -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Metode Pembayaran <span class="text-red-500">*</span></h3>
                <div class="space-y-2">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="payment_methods[]" value="cod"
                               {{ in_array('cod', old('payment_methods', [])) ? 'checked' : '' }}
                               class="w-4 h-4 text-purple-600 rounded">
                        <span class="text-sm font-medium">COD (Bayar di tempat)</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="payment_methods[]" value="rekber"
                               {{ in_array('rekber', old('payment_methods', [])) ? 'checked' : '' }}
                               class="w-4 h-4 text-purple-600 rounded">
                        <span class="text-sm font-medium">Rekening Bersama</span>
                    </label>
                </div>
                @error('payment_methods')<p class="text-red-500 text-xs mt-2">{{ $message }}</p>@enderror
            </div>

            <!-- Submit -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <button type="submit"
                        class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 rounded-lg text-sm transition">
                    Publish Produk
                </button>
                <a href="{{ route('merchant.products') }}"
                   class="block w-full text-center mt-2 text-sm text-gray-500 hover:text-gray-700 py-2">
                    Batal
                </a>
            </div>
        </div>
    </div>
</form>
@endsection
