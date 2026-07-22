@extends('layouts.app')
@section('title', 'Daftar Merchant — GadgetHub')

@section('content')
<div class="page-container py-10">
<div class="mx-auto max-w-3xl">

    {{-- Page Header --}}
    <div class="mb-8 text-center">
        <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-3xl bg-purple-100">
            <svg class="h-8 w-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
            </svg>
        </div>
        <h1 class="text-2xl font-extrabold tracking-tight text-slate-900 md:text-3xl">Daftar sebagai Merchant</h1>
        <p class="mt-2 text-sm text-slate-500 max-w-md mx-auto">
            Lengkapi data di bawah untuk mengajukan pendaftaran sebagai Merchant GadgetHub
        </p>
    </div>

    {{-- Info Banner --}}
    <div class="alert alert-info mb-7">
        <div class="alert-icon bg-brand-500">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <p class="font-bold text-brand-900">Proses verifikasi 1–3 hari kerja</p>
            <p class="mt-0.5 text-xs text-brand-700">Pendaftaran akan direview oleh tim GadgetHub. Pastikan semua data benar dan foto dokumen jelas terbaca.</p>
        </div>
    </div>

    <form action="{{ route('merchant.apply.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf

    {{-- ── SEKSI 1: DATA DIRI ── --}}
    <div class="card overflow-hidden">
        <div class="flex items-center gap-3 border-b border-slate-100 bg-purple-50/60 px-6 py-4">
            <span class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-xl bg-purple-600 text-xs font-extrabold text-white">1</span>
            <h2 class="font-bold text-slate-800">Data Diri Pemilik</h2>
        </div>
        <div class="grid grid-cols-1 gap-4 p-6 sm:grid-cols-2">

            <div class="form-group sm:col-span-2">
                <label class="input-label" for="owner_name">Nama Lengkap (sesuai KTP) <span class="text-rose-500">*</span></label>
                <input type="text" id="owner_name" name="owner_name" value="{{ old('owner_name') }}" required
                       placeholder="Nama sesuai KTP"
                       class="input-field @error('owner_name') error @enderror">
                @error('owner_name')<p class="input-error-msg">{{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label class="input-label" for="owner_nik">NIK (16 digit) <span class="text-rose-500">*</span></label>
                <input type="text" id="owner_nik" name="owner_nik" value="{{ old('owner_nik') }}"
                       required maxlength="16" placeholder="3271xxxxxxxxxxxxxxx"
                       class="input-field @error('owner_nik') error @enderror">
                @error('owner_nik')<p class="input-error-msg">{{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label class="input-label" for="owner_dob">Tanggal Lahir <span class="text-rose-500">*</span></label>
                <input type="date" id="owner_dob" name="owner_dob" value="{{ old('owner_dob') }}" required
                       class="input-field @error('owner_dob') error @enderror">
                @error('owner_dob')<p class="input-error-msg">{{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label class="input-label" for="owner_phone">No. HP Pemilik <span class="text-rose-500">*</span></label>
                <input type="text" id="owner_phone" name="owner_phone" value="{{ old('owner_phone') }}"
                       required placeholder="08xxxxxxxxxx"
                       class="input-field @error('owner_phone') error @enderror">
                @error('owner_phone')<p class="input-error-msg">{{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label class="input-label" for="owner_city">Kota <span class="text-rose-500">*</span></label>
                <input type="text" id="owner_city" name="owner_city" value="{{ old('owner_city') }}"
                       required placeholder="Jakarta Selatan" class="input-field">
                @error('owner_city')<p class="input-error-msg">{{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label class="input-label" for="owner_province">Provinsi <span class="text-rose-500">*</span></label>
                <input type="text" id="owner_province" name="owner_province" value="{{ old('owner_province') }}"
                       required placeholder="DKI Jakarta" class="input-field">
                @error('owner_province')<p class="input-error-msg">{{ $message }}</p>@enderror
            </div>

            <div class="form-group sm:col-span-2">
                <label class="input-label" for="owner_address">Alamat Lengkap <span class="text-rose-500">*</span></label>
                <textarea id="owner_address" name="owner_address" required rows="2"
                          placeholder="Jl. Sudirman No. 1 RT 01/RW 02"
                          class="input-field @error('owner_address') error @enderror">{{ old('owner_address') }}</textarea>
                @error('owner_address')<p class="input-error-msg">{{ $message }}</p>@enderror
            </div>

            <div class="form-group sm:col-span-2">
                <label class="input-label">
                    Foto KTP <span class="text-rose-500">*</span>
                    <span class="font-normal text-slate-400">JPG/PNG · maks. 2MB</span>
                </label>
                <label for="id_card_photo"
                       class="flex cursor-pointer items-center gap-3 rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50 px-5 py-4 transition-colors hover:border-purple-400 hover:bg-purple-50/40">
                    <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl bg-purple-100">
                        <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2"/>
                        </svg>
                    </div>
                    <span class="text-sm text-slate-600" id="ktp-label">Klik untuk upload foto KTP</span>
                    <input type="file" id="id_card_photo" name="id_card_photo" accept="image/*" required class="hidden"
                           onchange="updateLabel('id_card_photo','ktp-label')">
                </label>
                @error('id_card_photo')<p class="input-error-msg mt-1">{{ $message }}</p>@enderror
            </div>
        </div>
    </div>

    {{-- ── SEKSI 2: DATA TOKO ── --}}
    <div class="card overflow-hidden">
        <div class="flex items-center gap-3 border-b border-slate-100 bg-purple-50/60 px-6 py-4">
            <span class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-xl bg-purple-600 text-xs font-extrabold text-white">2</span>
            <h2 class="font-bold text-slate-800">Informasi Toko</h2>
        </div>
        <div class="grid grid-cols-1 gap-4 p-6 sm:grid-cols-2">

            <div class="form-group">
                <label class="input-label" for="store_name">Nama Toko <span class="text-rose-500">*</span></label>
                <input type="text" id="store_name" name="store_name" value="{{ old('store_name') }}"
                       required placeholder="Toko Gadget Jaya"
                       class="input-field @error('store_name') error @enderror">
                @error('store_name')<p class="input-error-msg">{{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label class="input-label" for="store_category">Jenis Produk <span class="text-rose-500">*</span></label>
                <input type="text" id="store_category" name="store_category" value="{{ old('store_category') }}"
                       required placeholder="Smartphone, Laptop, Aksesori"
                       class="input-field @error('store_category') error @enderror">
                @error('store_category')<p class="input-error-msg">{{ $message }}</p>@enderror
            </div>

            <div class="form-group sm:col-span-2">
                <label class="input-label" for="store_description">Deskripsi Toko <span class="text-rose-500">*</span></label>
                <textarea id="store_description" name="store_description" required rows="3"
                          placeholder="Ceritakan tentang toko Anda, produk yang dijual, pengalaman, dll…"
                          class="input-field @error('store_description') error @enderror">{{ old('store_description') }}</textarea>
                @error('store_description')<p class="input-error-msg">{{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label class="input-label" for="store_phone">No. HP Toko <span class="text-rose-500">*</span></label>
                <input type="text" id="store_phone" name="store_phone" value="{{ old('store_phone') }}"
                       required placeholder="08xxxxxxxxxx" class="input-field">
                @error('store_phone')<p class="input-error-msg">{{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label class="input-label" for="store_email">
                    Email Toko
                    <span class="font-normal text-slate-400">(opsional)</span>
                </label>
                <input type="email" id="store_email" name="store_email" value="{{ old('store_email') }}"
                       placeholder="toko@email.com" class="input-field">
            </div>

            <div class="form-group">
                <label class="input-label" for="store_city">Kota Toko <span class="text-rose-500">*</span></label>
                <input type="text" id="store_city" name="store_city" value="{{ old('store_city') }}"
                       required placeholder="Bandung" class="input-field">
            </div>

            <div class="form-group">
                <label class="input-label" for="store_province">Provinsi Toko <span class="text-rose-500">*</span></label>
                <input type="text" id="store_province" name="store_province" value="{{ old('store_province') }}"
                       required placeholder="Jawa Barat" class="input-field">
            </div>

            <div class="form-group sm:col-span-2">
                <label class="input-label" for="store_address">Alamat Toko <span class="text-rose-500">*</span></label>
                <textarea id="store_address" name="store_address" required rows="2"
                          placeholder="Jl. Asia Afrika No. 10" class="input-field">{{ old('store_address') }}</textarea>
            </div>

            <div class="form-group sm:col-span-2">
                <label class="input-label">
                    Logo Toko
                    <span class="font-normal text-slate-400">(opsional · JPG/PNG/WebP · maks. 2MB)</span>
                </label>
                <label for="store_logo"
                       class="flex cursor-pointer items-center gap-3 rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50 px-5 py-4 transition-colors hover:border-purple-400 hover:bg-purple-50/40">
                    <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl bg-slate-100">
                        <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <span class="text-sm text-slate-600" id="logo-label">Klik untuk upload logo toko</span>
                    <input type="file" id="store_logo" name="store_logo" accept="image/*" class="hidden"
                           onchange="updateLabel('store_logo','logo-label')">
                </label>
            </div>
        </div>
    </div>

    {{-- ── SEKSI 3: LEGALITAS & REKENING ── --}}
    <div class="card overflow-hidden">
        <div class="flex items-center gap-3 border-b border-slate-100 bg-purple-50/60 px-6 py-4">
            <span class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-xl bg-purple-600 text-xs font-extrabold text-white">3</span>
            <h2 class="font-bold text-slate-800">Legalitas &amp; Rekening Bank</h2>
        </div>
        <div class="grid grid-cols-1 gap-4 p-6 sm:grid-cols-2">

            <div class="form-group">
                <label class="input-label" for="npwp">
                    NPWP
                    <span class="font-normal text-slate-400">(opsional)</span>
                </label>
                <input type="text" id="npwp" name="npwp" value="{{ old('npwp') }}"
                       maxlength="20" placeholder="XX.XXX.XXX.X-XXX.XXX" class="input-field">
            </div>

            <div class="form-group">
                <label class="input-label" for="siup_nib">
                    SIUP / NIB
                    <span class="font-normal text-slate-400">(opsional)</span>
                </label>
                <input type="text" id="siup_nib" name="siup_nib" value="{{ old('siup_nib') }}"
                       placeholder="Nomor SIUP atau NIB" class="input-field">
            </div>

            <div class="form-group sm:col-span-2">
                <label class="input-label">
                    Foto NPWP
                    <span class="font-normal text-slate-400">(opsional · JPG/PNG · maks. 2MB)</span>
                </label>
                <label for="npwp_photo"
                       class="flex cursor-pointer items-center gap-3 rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50 px-5 py-4 transition-colors hover:border-purple-400 hover:bg-purple-50/40">
                    <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl bg-slate-100">
                        <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <span class="text-sm text-slate-600" id="npwp-label">Klik untuk upload foto NPWP</span>
                    <input type="file" id="npwp_photo" name="npwp_photo" accept="image/*" class="hidden"
                           onchange="updateLabel('npwp_photo','npwp-label')">
                </label>
            </div>

            {{-- Rekening --}}
            <div class="sm:col-span-2">
                <div class="mb-3 flex items-center gap-2">
                    <div class="h-px flex-1 bg-slate-100"></div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Rekening Pembayaran</p>
                    <div class="h-px flex-1 bg-slate-100"></div>
                </div>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div class="form-group">
                        <label class="input-label" for="bank_name">Nama Bank <span class="text-rose-500">*</span></label>
                        <input type="text" id="bank_name" name="bank_name" value="{{ old('bank_name') }}"
                               required placeholder="BCA, BRI, Mandiri…"
                               class="input-field @error('bank_name') error @enderror">
                        @error('bank_name')<p class="input-error-msg">{{ $message }}</p>@enderror
                    </div>
                    <div class="form-group">
                        <label class="input-label" for="bank_account_number">No. Rekening <span class="text-rose-500">*</span></label>
                        <input type="text" id="bank_account_number" name="bank_account_number"
                               value="{{ old('bank_account_number') }}" required placeholder="1234567890"
                               class="input-field @error('bank_account_number') error @enderror">
                        @error('bank_account_number')<p class="input-error-msg">{{ $message }}</p>@enderror
                    </div>
                    <div class="form-group">
                        <label class="input-label" for="bank_account_name">Nama Pemilik Rekening <span class="text-rose-500">*</span></label>
                        <input type="text" id="bank_account_name" name="bank_account_name"
                               value="{{ old('bank_account_name') }}" required placeholder="Nama Lengkap"
                               class="input-field @error('bank_account_name') error @enderror">
                        @error('bank_account_name')<p class="input-error-msg">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Pernyataan & Submit ── --}}
    <div class="card p-6">
        <label class="flex cursor-pointer items-start gap-3">
            <input type="checkbox" required
                   class="mt-0.5 h-4 w-4 flex-shrink-0 cursor-pointer rounded border-slate-300 accent-purple-600">
            <span class="text-sm text-slate-600 leading-relaxed">
                Saya menyatakan bahwa semua data yang saya isi adalah <strong class="text-slate-800">benar dan dapat dipertanggungjawabkan</strong>.
                Saya menyetujui <a href="#" class="font-semibold text-purple-600 hover:underline">Syarat &amp; Ketentuan Merchant</a> GadgetHub.
            </span>
        </label>

        <div class="mt-5 flex flex-col gap-3 sm:flex-row">
            <button type="submit" class="btn-merchant flex-1 py-3.5 text-sm font-bold">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                </svg>
                Kirim Pendaftaran
            </button>
            <a href="{{ route('products.index') }}"
               class="btn-secondary py-3.5 px-6 text-sm">
                Batal
            </a>
        </div>
    </div>

    </form>
</div>
</div>

@push('scripts')
<script>
function updateLabel(inputId, labelId) {
    const input = document.getElementById(inputId);
    const label = document.getElementById(labelId);
    if (input.files && input.files[0]) {
        label.textContent = input.files[0].name;
        label.classList.add('font-semibold', 'text-purple-700');
    }
}
</script>
@endpush

@endsection
