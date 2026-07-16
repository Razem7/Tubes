@extends('layouts.admin')

@section('title', 'GadgetHub - Kelola Kategori')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Kelola Kategori</h2>
    <p class="text-sm text-gray-500 mt-1">Kategori ini digunakan oleh merchant saat upload produk</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Form Tambah -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="font-semibold text-gray-800 mb-4">Tambah Kategori Baru</h3>
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-400 @error('name') border-red-400 @enderror"
                       placeholder="Contoh: Laptop Gaming">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit"
                    class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded-lg text-sm font-semibold transition">
                + Tambah Kategori
            </button>
        </form>
    </div>

    <!-- List Kategori -->
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm">
        <div class="px-6 py-4 border-b flex items-center justify-between">
            <h3 class="font-semibold text-gray-800">Daftar Kategori</h3>
            <span class="text-sm text-gray-400">{{ $categories->count() }} kategori</span>
        </div>
        <div class="divide-y">
            @forelse($categories as $category)
            <div x-data="{ editing: false }">
                <!-- Normal row -->
                <div x-show="!editing" class="flex items-center justify-between px-6 py-3 gap-4">
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-medium text-gray-800">{{ $category->name }}</span>
                        <span class="text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full">
                            {{ $category->products_count }} produk
                        </span>
                    </div>
                    <div class="flex items-center gap-3 flex-shrink-0">
                        <button @click="editing = true"
                                class="text-xs text-blue-600 hover:underline font-medium">Edit</button>
                        <form action="{{ route('admin.categories.delete', $category) }}" method="POST"
                              onsubmit="return confirm('Hapus kategori {{ addslashes($category->name) }}?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="text-xs font-medium {{ $category->products_count > 0 ? 'text-gray-300 cursor-not-allowed' : 'text-red-500 hover:underline' }}"
                                    {{ $category->products_count > 0 ? 'disabled' : '' }}
                                    title="{{ $category->products_count > 0 ? 'Masih ada produk dalam kategori ini' : '' }}">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Edit row -->
                <div x-show="editing" class="px-6 py-3 bg-blue-50">
                    <form action="{{ route('admin.categories.update', $category) }}" method="POST"
                          class="flex items-center gap-2">
                        @csrf @method('PUT')
                        <input type="text" name="name" value="{{ $category->name }}" required
                               class="flex-1 px-3 py-1.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <button type="submit"
                                class="bg-blue-600 text-white text-xs px-3 py-1.5 rounded-lg hover:bg-blue-700 whitespace-nowrap">
                            Simpan
                        </button>
                        <button type="button" @click="editing = false"
                                class="text-xs text-gray-500 hover:text-gray-700 px-2 py-1.5">
                            Batal
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="px-6 py-10 text-center text-sm text-gray-400">
                Belum ada kategori. Tambahkan kategori pertama.
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush
