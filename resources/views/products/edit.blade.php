@extends('layouts.app')

@section('title', 'GadgetHub - Edit Produk')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-bold mb-6">Edit Produk</h2>
        
        <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="title" class="block text-gray-700 mb-2">Judul Iklan *</label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="{{ old('title', $product->title) }}"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror"
                       required>
                @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 mb-2">Deskripsi *</label>
                <textarea id="description" 
                          name="description" 
                          rows="5"
                          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror"
                          required>{{ old('description', $product->description) }}</textarea>
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
                           value="{{ old('price', $product->price) }}"
                           min="1"
                           step="1"
                           placeholder="Contoh: 3500000"
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
                        <option value="new" {{ old('condition', $product->condition) == 'new' ? 'selected' : '' }}>Baru</option>
                        <option value="like_new" {{ old('condition', $product->condition) == 'like_new' ? 'selected' : '' }}>Seperti Baru</option>
                        <option value="good" {{ old('condition', $product->condition) == 'good' ? 'selected' : '' }}>Baik</option>
                        <option value="fair" {{ old('condition', $product->condition) == 'fair' ? 'selected' : '' }}>Cukup Baik</option>
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
                       value="{{ old('location', $product->location) }}"
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
                           value="{{ old('brand', $product->brand) }}"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="model" class="block text-gray-700 mb-2">Model</label>
                    <input type="text" 
                           id="model" 
                           name="model" 
                           value="{{ old('model', $product->model) }}"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            @include('products.components.category-select')

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Foto Saat Ini</label>
                <div class="grid grid-cols-4 gap-2">
                    @foreach($product->photos as $photo)
                    <div class="relative">
                        <img src="{{ $photo->photo_url ? asset($photo->photo_url) : 'https://via.placeholder.com/100x100?text=No+Image' }}" 
                             alt="Photo"
                             class="w-full h-20 object-cover rounded">
                        <label class="absolute top-1 right-1 bg-red-600 text-white text-xs px-2 py-1 rounded cursor-pointer">
                            <input type="checkbox" name="delete_photos[]" value="{{ $photo->id }}" class="mr-1">
                            Hapus
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="mb-6">
                <label for="new_photos" class="block text-gray-700 mb-2">Tambah Foto Baru (Opsional)</label>
                <input type="file" 
                       id="new_photos" 
                       name="new_photos[]" 
                       multiple
                       accept="image/jpeg,image/png,image/jpg"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG. Maksimal 5MB per foto</p>
                @error('new_photos.*')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                    Update Produk
                </button>
                <a href="{{ route('products.my') }}" class="flex-1 bg-gray-100 text-gray-700 py-2 rounded-lg hover:bg-gray-200 text-center text-sm font-medium">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
