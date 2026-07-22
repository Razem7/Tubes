@extends('layouts.admin')
@section('title', 'Kelola Banner — Super Admin GadgetHub')

@section('content')

{{-- Header --}}
<div class="mb-7">
    <p class="section-eyebrow text-rose-600">Konten</p>
    <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Kelola Banner</h1>
    <p class="mt-0.5 text-sm text-slate-500">Upload gambar banner yang ditampilkan di halaman utama</p>
</div>

<div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

    {{-- ── Current Banner Preview ── --}}
    <div class="card overflow-hidden">
        <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
            <h3 class="font-bold text-slate-800">Banner Saat Ini</h3>
            @if($banner)
            <span class="badge badge-emerald">Aktif</span>
            @else
            <span class="badge badge-slate">Tidak ada</span>
            @endif
        </div>

        @if($banner)
        <div class="p-5">
            {{-- Preview image --}}
            <div class="mb-4 overflow-hidden rounded-2xl border border-slate-200 bg-slate-100"
                 style="aspect-ratio:3/1;">
                <img src="{{ \Storage::url($banner->image_url) }}"
                     alt="{{ $banner->title }}"
                     class="h-full w-full object-cover">
            </div>

            {{-- Meta --}}
            <dl class="mb-5 space-y-2.5 text-sm">
                <div class="flex items-start gap-2">
                    <dt class="w-14 flex-shrink-0 text-xs font-semibold uppercase tracking-wider text-slate-400">Judul</dt>
                    <dd class="text-slate-700">{{ $banner->title ?: '—' }}</dd>
                </div>
                <div class="flex items-start gap-2">
                    <dt class="w-14 flex-shrink-0 text-xs font-semibold uppercase tracking-wider text-slate-400">Link</dt>
                    <dd class="min-w-0">
                        @if($banner->link_url)
                        <a href="{{ $banner->link_url }}" target="_blank"
                           class="truncate text-brand-600 hover:underline">{{ $banner->link_url }}</a>
                        @else
                        <span class="text-slate-400">—</span>
                        @endif
                    </dd>
                </div>
                <div class="flex items-start gap-2">
                    <dt class="w-14 flex-shrink-0 text-xs font-semibold uppercase tracking-wider text-slate-400">Dibuat</dt>
                    <dd class="text-slate-500">{{ $banner->created_at->format('d/m/Y H:i') }}</dd>
                </div>
            </dl>

            <form action="{{ route('admin.banners.delete') }}" method="POST"
                  onsubmit="return confirm('Hapus banner ini? Halaman utama akan kembali ke tampilan default.')">
                @csrf @method('DELETE')
                <button type="submit"
                        class="w-full rounded-2xl border border-rose-200 bg-rose-50 py-2.5 text-sm font-semibold text-rose-600 transition-colors hover:bg-rose-100 active:scale-95">
                    <svg class="mr-1.5 inline h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Hapus Banner
                </button>
            </form>
        </div>
        @else
        <div class="flex flex-col items-center justify-center px-5 py-16 text-center">
            <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100">
                <svg class="h-8 w-8 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <p class="text-sm font-semibold text-slate-500">Belum ada banner</p>
            <p class="mt-1 text-xs text-slate-400">Halaman utama menampilkan hero default</p>
        </div>
        @endif
    </div>

    {{-- ── Upload / Replace Form ── --}}
    <div class="card p-6">
        <h3 class="mb-1 font-bold text-slate-900">
            {{ $banner ? 'Ganti Banner' : 'Upload Banner' }}
        </h3>
        <p class="mb-5 text-xs text-slate-400">
            {{ $banner ? 'Upload gambar baru akan menggantikan banner saat ini.' : 'Upload gambar untuk ditampilkan di halaman utama.' }}
        </p>

        <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Drop zone --}}
            <div class="form-group mb-4">
                <label class="input-label">
                    Gambar Banner <span class="text-rose-500">*</span>
                    <span class="font-normal text-slate-400">JPG/PNG/WebP · maks. 3MB · rasio 3:1 disarankan</span>
                </label>
                <label id="upload-zone"
                       for="image-input"
                       class="flex cursor-pointer flex-col items-center justify-center gap-3 rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50/60 px-6 py-10 text-center transition-colors hover:border-rose-400 hover:bg-rose-50/30">
                    <img id="preview-img" src="" alt="" class="hidden mx-auto mb-1 max-h-36 w-full rounded-xl object-contain">
                    <div id="upload-placeholder">
                        <div class="mx-auto mb-2 flex h-12 w-12 items-center justify-center rounded-2xl bg-rose-100">
                            <svg class="h-6 w-6 text-rose-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-slate-700">Klik atau drag gambar ke sini</p>
                        <p class="mt-1 text-xs text-slate-400">Rekomendasi 1200×400 px</p>
                    </div>
                    <input type="file" id="image-input" name="image" accept="image/*" required class="hidden"
                           onchange="previewBanner(this)">
                </label>
                @error('image')
                <p class="input-error-msg mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label class="input-label" for="banner-title">
                    Judul
                    <span class="font-normal text-slate-400">(opsional)</span>
                </label>
                <input type="text" id="banner-title" name="title"
                       value="{{ old('title', $banner?->title) }}"
                       placeholder="Contoh: Promo Gadget Bekas Terpercaya"
                       class="input-field @error('title') error @enderror">
                @error('title')
                <p class="input-error-msg">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mb-6">
                <label class="input-label" for="banner-link">
                    Link URL
                    <span class="font-normal text-slate-400">(opsional — klik banner menuju link ini)</span>
                </label>
                <input type="url" id="banner-link" name="link_url"
                       value="{{ old('link_url', $banner?->link_url) }}"
                       placeholder="https://..."
                       class="input-field @error('link_url') error @enderror">
                @error('link_url')
                <p class="input-error-msg">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-rose-600 py-3.5 text-sm font-bold text-white transition-colors hover:bg-rose-700 active:scale-95">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                </svg>
                {{ $banner ? 'Ganti Banner' : 'Upload Banner' }}
            </button>
        </form>
    </div>

</div>

@push('scripts')
<script>
function previewBanner(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = function (e) {
        const img  = document.getElementById('preview-img');
        const ph   = document.getElementById('upload-placeholder');
        img.src = e.target.result;
        img.classList.remove('hidden');
        ph.classList.add('hidden');
    };
    reader.readAsDataURL(input.files[0]);
}

const zone = document.getElementById('upload-zone');
if (zone) {
    ['dragenter','dragover'].forEach(ev => zone.addEventListener(ev, e => {
        e.preventDefault();
        zone.classList.add('border-rose-400','bg-rose-50/40');
    }));
    ['dragleave','drop'].forEach(ev => zone.addEventListener(ev, () => {
        zone.classList.remove('border-rose-400','bg-rose-50/40');
    }));
    zone.addEventListener('drop', e => {
        e.preventDefault();
        const inp = document.getElementById('image-input');
        inp.files = e.dataTransfer.files;
        previewBanner(inp);
    });
}
</script>
@endpush

@endsection
