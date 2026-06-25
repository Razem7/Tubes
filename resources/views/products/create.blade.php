@extends('layouts.app')

@section('title', 'Pasang Iklan - GadgetHub')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-bold mb-6">Pasang Iklan HP Bekas</h2>
        
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-4">
                <label for="title" class="block text-gray-700 mb-2">Judul Iklan *</label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="{{ old('title') }}"
                       placeholder="Contoh: iPhone 12 Pro 128GB Fullset"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror"
                       required>
                <p class="text-sm text-gray-500 mt-1">Minimal 10 karakter, maksimal 100 karakter</p>
                @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 mb-2">Deskripsi *</label>
                <textarea id="description" 
                          name="description" 
                          rows="5"
                          placeholder="Jelaskan kondisi HP, kelengkapan, dll..."
                          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror"
                          required>{{ old('description') }}</textarea>
                <p class="text-sm text-gray-500 mt-1">Minimal 20 karakter, maksimal 2000 karakter</p>
                @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="price" class="block text-gray-700 mb-2">Harga (Rp) *</label>
                    <input type="number" 
                           id="price" 
                           name="price" 
                           value="{{ old('price') }}"
                           placeholder="Contoh: 3500000"
                           min="1"
                           step="1"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('price') border-red-500 @enderror"
                           required>
                    <p class="text-sm text-gray-500 mt-1">Masukkan harga dalam rupiah penuh (tidak pakai koma atau titik)</p>
                    @error('price')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="condition" class="block text-gray-700 mb-2">Kondisi *</label>
                    <select id="condition" 
                            name="condition"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('condition') border-red-500 @enderror"
                            required>
                        <option value="">Pilih Kondisi</option>
                        <option value="new" {{ old('condition') == 'new' ? 'selected' : '' }}>Baru</option>
                        <option value="like_new" {{ old('condition') == 'like_new' ? 'selected' : '' }}>Seperti Baru</option>
                        <option value="good" {{ old('condition') == 'good' ? 'selected' : '' }}>Baik</option>
                        <option value="fair" {{ old('condition') == 'fair' ? 'selected' : '' }}>Cukup Baik</option>
                    </select>
                    @error('condition')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="location" class="block text-gray-700 mb-2">Lokasi *</label>
                <input type="text" 
                       id="location" 
                       name="location" 
                       value="{{ old('location') }}"
                       placeholder="Contoh: Jakarta Selatan"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('location') border-red-500 @enderror"
                       required>
                @error('location')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="brand" class="block text-gray-700 mb-2">Brand</label>
                    <input type="text" 
                           id="brand" 
                           name="brand" 
                           value="{{ old('brand') }}"
                           placeholder="Samsung, iPhone, Xiaomi, dll"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="model" class="block text-gray-700 mb-2">Model</label>
                    <input type="text" 
                           id="model" 
                           name="model" 
                           value="{{ old('model') }}"
                           placeholder="iPhone 12 Pro, Galaxy S21, dll"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            @include('products.components.category-select')

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Metode Pembayaran *</label>
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input type="checkbox" name="payment_methods[]" value="cod" class="mr-2" {{ is_array(old('payment_methods')) && in_array('cod', old('payment_methods')) ? 'checked' : '' }}>
                        <span>COD (Cash on Delivery)</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="payment_methods[]" value="rekber" class="mr-2" {{ is_array(old('payment_methods')) && in_array('rekber', old('payment_methods')) ? 'checked' : '' }}>
                        <span>Rekening Bersama (Rekber)</span>
                    </label>
                </div>
                @error('payment_methods')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="photos" class="block text-gray-700 mb-2">Foto Produk * (1-8 foto)</label>
                <input type="file" 
                       id="photos" 
                       name="photos[]" 
                       multiple
                       accept="image/jpeg,image/png,image/jpg"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('photos') border-red-500 @enderror"
                       required>
                <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG. Maksimal 5MB per foto</p>
                @error('photos')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                @error('photos.*')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                    Pasang Iklan
                </button>
                <a href="{{ route('products.index') }}" class="flex-1 bg-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-400 text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
