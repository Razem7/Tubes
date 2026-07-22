@extends('layouts.merchant')
@section('title', 'Tambah Produk — Merchant GadgetHub')

@section('content')

{{-- Breadcrumb --}}
<div class="mb-6">
    <a href="{{ route('merchant.products') }}"
       class="inline-flex items-center gap-1.5 text-sm text-slate-500 transition-colors hover:text-purple-600">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali ke Produk
    </a>
    <div class="mt-3">
        <p class="section-eyebrow">Tambah Baru</p>
        <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Tambah Produk</h1>
    </div>
</div>

<form action="{{ route('merchant.products.store') }}" method="POST" enctype="multipart/form-data"
      id="create-product-form">
@csrf

<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

    {{-- ── Main Column ── --}}
    <div class="space-y-5 lg:col-span-2">

        {{-- Informasi Produk --}}
        <div class="card p-6">
            <h3 class="mb-5 flex items-center gap-2 text-base font-bold text-slate-900">
                <span class="flex h-7 w-7 items-center justify-center rounded-xl bg-purple-100 text-xs font-extrabold text-purple-700">1</span>
                Informasi Produk
            </h3>

            <div class="space-y-4">
                <div class="form-group">
                    <label class="input-label" for="title">
                        Nama Produk <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required
                           placeholder="Contoh: iPhone 13 Pro Max 256GB Midnight"
                           class="input-field @error('title') error @enderror">
                    @error('title')
                    <p class="input-error-msg">
                        <svg class="h-3.5 w-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                    @enderror
                    <p class="input-hint">Min. 10 karakter, maks. 100 karakter</p>
                </div>

                <div class="form-group">
                    <label class="input-label" for="description">
                        Deskripsi <span class="text-rose-500">*</span>
                    </label>
                    <textarea id="description" name="description" rows="5" required
                              placeholder="Deskripsikan kondisi, spesifikasi, kelengkapan aksesori, dan hal penting lainnya…"
                              class="input-field @error('description') error @enderror">{{ old('description') }}</textarea>
                    @error('description')
                    <p class="input-error-msg">
                        <svg class="h-3.5 w-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                    @enderror
                    <p class="input-hint">Min. 20 karakter, maks. 2000 karakter</p>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="form-group">
                        <label class="input-label" for="price">
                            Harga (Rp) <span class="text-rose-500">*</span>
                        </label>
                        <input type="number" id="price" name="price" value="{{ old('price') }}"
                               required min="1" placeholder="1500000"
                               class="input-field @error('price') error @enderror">
                        @error('price')
                        <p class="input-error-msg">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="input-label" for="stock">
                            Stok <span class="text-rose-500">*</span>
                        </label>
                        <input type="number" id="stock" name="stock" value="{{ old('stock', 1) }}"
                               required min="1"
                               class="input-field @error('stock') error @enderror">
                        @error('stock')
                        <p class="input-error-msg">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Detail Produk --}}
        <div class="card p-6">
            <h3 class="mb-5 flex items-center gap-2 text-base font-bold text-slate-900">
                <span class="flex h-7 w-7 items-center justify-center rounded-xl bg-purple-100 text-xs font-extrabold text-purple-700">2</span>
                Detail Produk
            </h3>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="form-group">
                    <label class="input-label" for="category_id">
                        Kategori <span class="text-rose-500">*</span>
                    </label>
                    <select id="category_id" name="category_id" required
                            class="input-field @error('category_id') error @enderror">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <p class="input-error-msg">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="input-label" for="condition">
                        Kondisi <span class="text-rose-500">*</span>
                    </label>
                    <select id="condition" name="condition" required class="input-field">
                        <option value="">Pilih Kondisi</option>
                        <option value="new"      {{ old('condition') === 'new'      ? 'selected' : '' }}>Baru</option>
                        <option value="like_new" {{ old('condition') === 'like_new' ? 'selected' : '' }}>Seperti Baru</option>
                        <option value="good"     {{ old('condition') === 'good'     ? 'selected' : '' }}>Baik (Normal)</option>
                        <option value="fair"     {{ old('condition') === 'fair'     ? 'selected' : '' }}>Cukup Baik</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="input-label" for="brand">Brand</label>
                    <input type="text" id="brand" name="brand" value="{{ old('brand') }}"
                           placeholder="Apple, Samsung, Xiaomi…" class="input-field">
                </div>

                <div class="form-group">
                    <label class="input-label" for="model">Model</label>
                    <input type="text" id="model" name="model" value="{{ old('model') }}"
                           placeholder="iPhone 13, Galaxy S22…" class="input-field">
                </div>

                <div class="form-group sm:col-span-2">
                    <label class="input-label" for="location">
                        Lokasi <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="location" name="location" value="{{ old('location') }}"
                           required placeholder="Contoh: Jakarta Selatan" class="input-field">
                </div>
            </div>
        </div>

        {{-- Foto Produk --}}
        <div class="card p-6">
            <h3 class="mb-2 flex items-center gap-2 text-base font-bold text-slate-900">
                <span class="flex h-7 w-7 items-center justify-center rounded-xl bg-purple-100 text-xs font-extrabold text-purple-700">3</span>
                Foto Produk
                <span class="text-sm font-normal text-slate-400">maks. 8 foto</span>
            </h3>
            <p class="mb-4 text-xs text-slate-400">Format JPG/PNG, ukuran maks. 5MB per foto. Foto pertama akan jadi foto utama.</p>

            {{-- Drop zone --}}
            <label for="photos-input"
                   class="flex cursor-pointer flex-col items-center justify-center gap-3 rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50/60 px-6 py-10 text-center transition-colors hover:border-purple-400 hover:bg-purple-50/40"
                   id="drop-zone">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-purple-100">
                    <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-700">Klik untuk upload foto</p>
                    <p class="text-xs text-slate-400">atau drag &amp; drop ke sini</p>
                </div>
                <input type="file" id="photos-input" name="photos[]" multiple accept="image/*" class="hidden"
                       onchange="previewPhotos(this)">
            </label>

            {{-- Preview --}}
            <div id="photo-preview" class="mt-4 hidden">
                <p class="mb-2 text-xs font-semibold text-slate-500">Preview:</p>
                <div id="preview-grid" class="grid grid-cols-4 gap-3 sm:grid-cols-6"></div>
            </div>

            @error('photos')
            <p class="input-error-msg mt-2">{{ $message }}</p>
            @enderror
            @error('photos.*')
            <p class="input-error-msg mt-2">{{ $message }}</p>
            @enderror
        </div>
    </div>

    {{-- ── Sidebar ── --}}
    <div class="space-y-5">

        {{-- Payment method info --}}
        <div class="card p-5">
            <h4 class="mb-3 text-sm font-bold text-slate-800">Metode Pembayaran</h4>
            <div class="flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 p-4">
                <div class="mt-0.5 flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl bg-emerald-100">
                    <svg class="h-5 w-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-emerald-800">COD — Bayar di Tempat</p>
                    <p class="mt-0.5 text-xs leading-relaxed text-emerald-600">Pembeli membayar langsung saat barang diterima.</p>
                </div>
            </div>
        </div>

        {{-- Tips --}}
        <div class="card p-5">
            <h4 class="mb-3 text-sm font-bold text-slate-800">Tips Produk Laris</h4>
            <ul class="space-y-2.5 text-xs text-slate-500">
                <li class="flex items-start gap-2">
                    <svg class="mt-0.5 h-4 w-4 flex-shrink-0 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    Gunakan foto yang terang dan tajam dari berbagai sudut
                </li>
                <li class="flex items-start gap-2">
                    <svg class="mt-0.5 h-4 w-4 flex-shrink-0 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    Tulis deskripsi lengkap termasuk kondisi cacat kecil
                </li>
                <li class="flex items-start gap-2">
                    <svg class="mt-0.5 h-4 w-4 flex-shrink-0 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    Cantumkan merek dan model untuk mudah dicari
                </li>
                <li class="flex items-start gap-2">
                    <svg class="mt-0.5 h-4 w-4 flex-shrink-0 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    Harga kompetitif meningkatkan peluang penjualan
                </li>
            </ul>
        </div>

        {{-- Submit actions --}}
        <div class="card p-5">
            <button type="submit" class="btn-merchant w-full py-3 text-sm font-bold">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Publish Produk
            </button>
            <a href="{{ route('merchant.products') }}"
               class="mt-2.5 block w-full rounded-2xl py-2.5 text-center text-sm text-slate-500 transition-colors hover:text-slate-800">
                Batal
            </a>
        </div>
    </div>

</div>
</form>

@push('scripts')
<script>
function previewPhotos(input) {
    const grid    = document.getElementById('preview-grid');
    const wrapper = document.getElementById('photo-preview');
    grid.innerHTML = '';
    if (!input.files || !input.files.length) { wrapper.classList.add('hidden'); return; }
    wrapper.classList.remove('hidden');
    Array.from(input.files).slice(0, 8).forEach(file => {
        const reader = new FileReader();
        reader.onload = e => {
            const div = document.createElement('div');
            div.className = 'aspect-square overflow-hidden rounded-xl border border-slate-200 bg-slate-100';
            div.innerHTML = `<img src="${e.target.result}" class="h-full w-full object-cover">`;
            grid.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
}

// Drag & drop highlight
const zone = document.getElementById('drop-zone');
if (zone) {
    ['dragenter','dragover'].forEach(ev => zone.addEventListener(ev, e => {
        e.preventDefault(); zone.classList.add('border-purple-500','bg-purple-50');
    }));
    ['dragleave','drop'].forEach(ev => zone.addEventListener(ev, () => {
        zone.classList.remove('border-purple-500','bg-purple-50');
    }));
    zone.addEventListener('drop', e => {
        e.preventDefault();
        const inp = document.getElementById('photos-input');
        inp.files = e.dataTransfer.files;
        previewPhotos(inp);
    });
}
</script>
@endpush

@endsection
