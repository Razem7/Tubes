@extends('layouts.admin')
@section('title', 'Kelola Kategori — Super Admin GadgetHub')

@section('content')

{{-- Header --}}
<div class="mb-7">
    <p class="section-eyebrow text-rose-600">Manajemen</p>
    <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Kelola Kategori</h1>
    <p class="mt-0.5 text-sm text-slate-500">Kategori ini digunakan oleh merchant saat upload produk</p>
</div>

<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

    {{-- ── Add Category Form ── --}}
    <div class="card p-6">
        <h3 class="mb-5 flex items-center gap-2 text-base font-bold text-slate-900">
            <span class="flex h-7 w-7 items-center justify-center rounded-xl bg-rose-100 text-xs font-extrabold text-rose-600">+</span>
            Tambah Kategori Baru
        </h3>

        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="form-group mb-4">
                <label class="input-label" for="cat-name">Nama Kategori</label>
                <input type="text" id="cat-name" name="name" value="{{ old('name') }}" required
                       placeholder="Contoh: Laptop Gaming"
                       class="input-field @error('name') error @enderror">
                @error('name')
                <p class="input-error-msg">
                    <svg class="h-3.5 w-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    {{ $message }}
                </p>
                @enderror
                <p class="input-hint">Gunakan nama yang jelas dan mudah dipahami pembeli</p>
            </div>

            <button type="submit"
                    class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-rose-600 py-3 text-sm font-bold text-white transition-colors hover:bg-rose-700 active:scale-95">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Kategori
            </button>
        </form>

        {{-- Info box --}}
        <div class="mt-5 rounded-2xl border border-amber-100 bg-amber-50 p-4">
            <p class="text-xs font-semibold text-amber-700 mb-1">Perhatian</p>
            <p class="text-xs text-amber-600 leading-relaxed">
                Kategori yang sudah memiliki produk tidak dapat dihapus. Hapus atau pindahkan produk terlebih dahulu.
            </p>
        </div>
    </div>

    {{-- ── Category List ── --}}
    <div class="card overflow-hidden lg:col-span-2">
        <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
            <h3 class="font-bold text-slate-800">Daftar Kategori</h3>
            <span class="badge badge-slate">{{ $categories->count() }} kategori</span>
        </div>

        <div class="divide-y divide-slate-50">
            @forelse($categories as $category)
            <div x-data="{ editing: false }">

                {{-- Normal row --}}
                <div x-show="!editing"
                     class="flex items-center justify-between gap-4 px-6 py-3.5 transition-colors hover:bg-slate-50/60">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-xl bg-rose-50">
                            <svg class="h-4 w-4 text-rose-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-slate-800">{{ $category->name }}</p>
                            <p class="text-xs text-slate-400">{{ $category->products_count }} produk</p>
                        </div>
                    </div>
                    <div class="flex flex-shrink-0 items-center gap-3">
                        <span class="badge badge-slate text-[10px]">{{ $category->products_count }} produk</span>
                        <button @click="editing = true"
                                class="rounded-xl border border-brand-200 bg-brand-50 px-3 py-1.5 text-xs font-semibold text-brand-700 transition-colors hover:bg-brand-100 active:scale-95">
                            Edit
                        </button>
                        <form action="{{ route('admin.categories.delete', $category) }}" method="POST"
                              onsubmit="return confirm('Hapus kategori {{ addslashes($category->name) }}?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="rounded-xl px-3 py-1.5 text-xs font-semibold transition-colors active:scale-95
                                           {{ $category->products_count > 0
                                               ? 'cursor-not-allowed border border-slate-100 bg-slate-50 text-slate-300'
                                               : 'border border-rose-200 bg-rose-50 text-rose-600 hover:bg-rose-100' }}"
                                    {{ $category->products_count > 0 ? 'disabled' : '' }}
                                    title="{{ $category->products_count > 0 ? 'Masih ada produk dalam kategori ini' : 'Hapus kategori' }}">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Edit inline row --}}
                <div x-show="editing" x-cloak
                     class="border-l-4 border-brand-500 bg-brand-50/40 px-6 py-3.5">
                    <form action="{{ route('admin.categories.update', $category) }}" method="POST"
                          class="flex items-center gap-3">
                        @csrf @method('PUT')
                        <input type="text" name="name" value="{{ $category->name }}" required
                               class="input-field flex-1 py-2"
                               autofocus>
                        <button type="submit"
                                class="whitespace-nowrap rounded-xl bg-brand-600 px-4 py-2 text-xs font-bold text-white transition-colors hover:bg-brand-700 active:scale-95">
                            Simpan
                        </button>
                        <button type="button" @click="editing = false"
                                class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-xs font-semibold text-slate-600 transition-colors hover:bg-slate-50 active:scale-95">
                            Batal
                        </button>
                    </form>
                </div>

            </div>
            @empty
            <div class="empty-state py-16 rounded-none border-0">
                <div class="empty-state-icon bg-slate-100 text-slate-400">
                    <svg class="h-7 w-7" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
                    </svg>
                </div>
                <h3 class="empty-state-title">Belum ada kategori</h3>
                <p class="empty-state-desc">Tambahkan kategori pertama menggunakan form di sebelah kiri.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

@push('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush

@endsection
