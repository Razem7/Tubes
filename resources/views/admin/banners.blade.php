@extends('layouts.admin')

@section('title', 'GadgetHub - Kelola Banner')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Kelola Banner</h2>
    <p class="text-sm text-gray-500 mt-1">Upload gambar banner yang ditampilkan di halaman utama</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Preview Banner Saat Ini --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b">
            <h3 class="font-semibold text-gray-800">Banner Saat Ini</h3>
        </div>
        @if($banner)
        <div class="p-5">
            <div class="rounded-xl overflow-hidden border bg-gray-50 mb-4" style="aspect-ratio: 3/1;">
                <img src="{{ asset('storage/' . $banner->image_url) }}"
                     alt="{{ $banner->title }}"
                     class="w-full h-full object-cover">
            </div>
            <div class="space-y-1 mb-5">
                <p class="text-sm text-gray-700">
                    <span class="font-medium text-gray-500">Judul:</span>
                    {{ $banner->title ?: '—' }}
                </p>
                <p class="text-sm text-gray-700">
                    <span class="font-medium text-gray-500">Link:</span>
                    @if($banner->link_url)
                        <a href="{{ $banner->link_url }}" target="_blank" class="text-blue-600 hover:underline truncate">{{ $banner->link_url }}</a>
                    @else
                        —
                    @endif
                </p>
                <p class="text-sm text-gray-500">Dipasang: {{ $banner->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <form action="{{ route('admin.banners.delete') }}" method="POST"
                  onsubmit="return confirm('Hapus banner ini? Halaman utama akan kembali ke tampilan default.')">
                @csrf @method('DELETE')
                <button type="submit"
                        class="w-full bg-red-50 hover:bg-red-100 text-red-600 text-sm font-semibold py-2.5 rounded-lg transition border border-red-200">
                    Hapus Banner
                </button>
            </form>
        </div>
        @else
        <div class="px-5 py-14 text-center text-gray-400">
            <svg class="w-14 h-14 mx-auto mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p class="text-sm font-medium">Belum ada banner</p>
            <p class="text-xs mt-1">Halaman utama menampilkan hero default</p>
        </div>
        @endif
    </div>

    {{-- Form Upload / Ganti Banner --}}
    <div class="bg-white rounded-xl shadow-sm p-5">
        <h3 class="font-semibold text-gray-800 mb-1">{{ $banner ? 'Ganti Banner' : 'Upload Banner' }}</h3>
        <p class="text-xs text-gray-400 mb-4">{{ $banner ? 'Upload gambar baru akan menggantikan banner saat ini.' : 'Upload gambar untuk ditampilkan di halaman utama.' }}</p>

        <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Upload area --}}
            <div class="mb-4">
                <label class="block text-xs font-semibold text-gray-600 mb-1">
                    Gambar Banner <span class="text-red-500">*</span>
                </label>
                <div id="upload-area"
                     class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition"
                     onclick="document.getElementById('image-input').click()">
                    <img id="preview-img" src="" alt="" class="hidden mx-auto mb-3 rounded-lg max-h-40 object-contain">
                    <div id="upload-placeholder">
                        <svg class="w-10 h-10 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-sm text-gray-500 font-medium">Klik untuk pilih gambar</p>
                        <p class="text-xs text-gray-400 mt-1">JPG, PNG, WebP — maks. 3MB</p>
                        <p class="text-xs text-gray-400">Rekomendasi rasio <strong>3:1</strong> (misal 1200×400 px)</p>
                    </div>
                </div>
                <input type="file" id="image-input" name="image" accept="image/*" class="hidden" required
                       onchange="previewBanner(this)">
                @error('image')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label class="block text-xs font-semibold text-gray-600 mb-1">Judul <span class="text-gray-400 font-normal">(opsional)</span></label>
                <input type="text" name="title" value="{{ old('title', $banner?->title) }}"
                       placeholder="Contoh: Promo Gadget Bekas Terpercaya"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-5">
                <label class="block text-xs font-semibold text-gray-600 mb-1">Link URL <span class="text-gray-400 font-normal">(opsional — klik banner menuju ke link ini)</span></label>
                <input type="url" name="link_url" value="{{ old('link_url', $banner?->link_url) }}"
                       placeholder="https://..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                @error('link_url')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-2.5 rounded-lg transition">
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
    reader.onload = function(e) {
        const img = document.getElementById('preview-img');
        img.src = e.target.result;
        img.classList.remove('hidden');
        document.getElementById('upload-placeholder').classList.add('hidden');
    };
    reader.readAsDataURL(input.files[0]);
}
</script>
@endpush

@endsection
