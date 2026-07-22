@extends('layouts.merchant')
@section('title', 'Edit Produk — Merchant GadgetHub')

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
        <p class="section-eyebrow">Edit Produk</p>
        <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Edit: {{ Str::limit($product->title, 50) }}</h1>
    </div>
</div>

<form action="{{ route('merchant.products.update', $product) }}" method="POST" enctype="multipart/form-data">
@csrf @method('PUT')

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
                    <input type="text" id="title" name="title"
                           value="{{ old('title', $product->title) }}" required
                           class="input-field @error('title') error @enderror">
                    @error('title')
                    <p class="input-error-msg">
                        <svg class="h-3.5 w-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="input-label" for="description">
                        Deskripsi <span class="text-rose-500">*</span>
                    </label>
                    <textarea id="description" name="description" rows="5" required
                              class="input-field @error('description') error @enderror">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                    <p class="input-error-msg">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="form-group">
                        <label class="input-label" for="price">
                            Harga (Rp) <span class="text-rose-500">*</span>
                        </label>
                        <input type="number" id="price" name="price"
                               value="{{ old('price', (int) $product->price) }}" required min="1"
                               class="input-field @error('price') error @enderror">
                        @error('price')
                        <p class="input-error-msg">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="input-label" for="stock">
                            Stok <span class="text-rose-500">*</span>
                        </label>
                        <input type="number" id="stock" name="stock"
                               value="{{ old('stock', $product->stock) }}" required min="0"
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
                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
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
                        <option value="new"      {{ old('condition', $product->condition) === 'new'      ? 'selected' : '' }}>Baru</option>
                        <option value="like_new" {{ old('condition', $product->condition) === 'like_new' ? 'selected' : '' }}>Seperti Baru</option>
                        <option value="good"     {{ old('condition', $product->condition) === 'good'     ? 'selected' : '' }}>Baik (Normal)</option>
                        <option value="fair"     {{ old('condition', $product->condition) === 'fair'     ? 'selected' : '' }}>Cukup Baik</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="input-label" for="brand">Brand</label>
                    <input type="text" id="brand" name="brand"
                           value="{{ old('brand', $product->brand) }}"
                           placeholder="Apple, Samsung…" class="input-field">
                </div>

                <div class="form-group">
                    <label class="input-label" for="model">Model</label>
                    <input type="text" id="model" name="model"
                           value="{{ old('model', $product->model) }}"
                           placeholder="iPhone 13, Galaxy S22…" class="input-field">
                </div>

                <div class="form-group sm:col-span-2">
                    <label class="input-label" for="location">
                        Lokasi <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="location" name="location"
                           value="{{ old('location', $product->location) }}" required class="input-field">
                </div>
            </div>
        </div>

        {{-- Foto Produk --}}
        <div class="card p-6">
            <h3 class="mb-2 flex items-center gap-2 text-base font-bold text-slate-900">
                <span class="flex h-7 w-7 items-center justify-center rounded-xl bg-purple-100 text-xs font-extrabold text-purple-700">3</span>
                Foto Produk
            </h3>

            {{-- Existing photos --}}
            @if($product->photos->count())
            <div class="mb-5">
                <p class="mb-3 text-xs font-semibold text-slate-500">Foto saat ini — centang untuk dihapus:</p>
                <div class="grid grid-cols-4 gap-3 sm:grid-cols-6">
                    @foreach($product->photos as $photo)
                    <label class="group relative cursor-pointer">
                        <input type="checkbox" name="delete_photos[]" value="{{ $photo->id }}"
                               class="peer absolute left-2 top-2 z-10 h-4 w-4 cursor-pointer accent-rose-500">
                        <div class="aspect-square overflow-hidden rounded-xl border-2 border-transparent
                                    transition-all peer-checked:border-rose-400 peer-checked:opacity-60">
                            <img src="{{ $photo->photo_url }}"
                                 class="h-full w-full object-cover"
                                 onerror="this.style.display='none'">
                        </div>
                        <div class="absolute inset-0 hidden items-center justify-center rounded-xl bg-rose-500/20 peer-checked:flex">
                            <svg class="h-6 w-6 text-rose-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Upload new --}}
            <label for="new-photos-input"
                   class="flex cursor-pointer flex-col items-center justify-center gap-3 rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50/60 px-6 py-8 text-center transition-colors hover:border-purple-400 hover:bg-purple-50/40">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-purple-100">
                    <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-700">Upload foto baru</p>
                    <p class="text-xs text-slate-400">JPG/PNG · maks. 5MB per foto</p>
                </div>
                <input type="file" id="new-photos-input" name="new_photos[]" multiple accept="image/*"
                       class="hidden" onchange="previewNewPhotos(this)">
            </label>

            <div id="new-photo-preview" class="mt-4 hidden">
                <p class="mb-2 text-xs font-semibold text-slate-500">Preview foto baru:</p>
                <div id="new-preview-grid" class="grid grid-cols-4 gap-3 sm:grid-cols-6"></div>
            </div>
        </div>
    </div>

    {{-- ── Sidebar ── --}}
    <div class="space-y-5">

        {{-- Payment info --}}
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
                    <p class="mt-0.5 text-xs text-emerald-600">Pembeli membayar langsung saat barang diterima.</p>
                </div>
            </div>
        </div>

        {{-- Danger zone --}}
        <div class="card p-5">
            <h4 class="mb-2 text-sm font-bold text-rose-700">Zona Berbahaya</h4>
            <p class="mb-3 text-xs text-slate-500">Menghapus produk bersifat permanen dan tidak dapat dibatalkan.</p>
            <form action="{{ route('merchant.products.destroy', $product) }}" method="POST"
                  onsubmit="return confirm('Hapus produk ini secara permanen?')">
                @csrf @method('DELETE')
                <button type="submit"
                        class="w-full rounded-2xl border border-rose-200 bg-rose-50 py-2.5 text-xs font-bold text-rose-600 transition-colors hover:bg-rose-100">
                    Hapus Produk Ini
                </button>
            </form>
        </div>

        {{-- Submit actions --}}
        <div class="card p-5">
            <button type="submit" class="btn-merchant w-full py-3 text-sm font-bold">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                </svg>
                Simpan Perubahan
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
function previewNewPhotos(input) {
    const grid    = document.getElementById('new-preview-grid');
    const wrapper = document.getElementById('new-photo-preview');
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
</script>
@endpush

@endsection
