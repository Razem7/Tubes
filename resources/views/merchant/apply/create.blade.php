@extends('layouts.app')

@section('title', 'Daftar Merchant - GadgetHub')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-10">

    {{-- Header --}}
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-14 h-14 bg-purple-100 rounded-2xl mb-3">
            <svg class="w-7 h-7 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-900">Daftar sebagai Merchant</h1>
        <p class="text-gray-500 text-sm mt-1">Lengkapi data di bawah ini untuk mengajukan pendaftaran sebagai Merchant GadgetHub</p>
    </div>

    {{-- Info Banner --}}
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6 flex gap-3">
        <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
        <div class="text-sm text-blue-700">
            <p class="font-semibold mb-0.5">Proses verifikasi 1–3 hari kerja</p>
            <p>Pendaftaran akan direview oleh tim GadgetHub. Pastikan semua data yang kamu isi benar dan foto dokumen jelas terbaca.</p>
        </div>
    </div>

    <form action="{{ route('merchant.apply.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- ── SEKSI 1: DATA DIRI PEMILIK ─────────────────────────────── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-purple-50 border-b border-purple-100 flex items-center gap-2">
                <span class="w-6 h-6 bg-purple-600 text-white text-xs font-bold rounded-full flex items-center justify-center">1</span>
                <h2 class="font-semibold text-gray-800">Data Diri Pemilik</h2>
            </div>
            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap (sesuai KTP) <span class="text-red-500">*</span></label>
                    <input type="text" name="owner_name" value="{{ old('owner_name') }}" required
                           class="w-full px-3 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 @error('owner_name') border-red-400 @enderror"
                           placeholder="Nama sesuai KTP">
                    @error('owner_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">NIK (16 digit) <span class="text-red-500">*</span></label>
                    <input type="text" name="owner_nik" value="{{ old('owner_nik') }}" required maxlength="16"
                           class="w-full px-3 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 @error('owner_nik') border-red-400 @enderror"
                           placeholder="3271xxxxxxxxxxxxxxx">
                    @error('owner_nik')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir <span class="text-red-500">*</span></label>
                    <input type="date" name="owner_dob" value="{{ old('owner_dob') }}" required
                           class="w-full px-3 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 @error('owner_dob') border-red-400 @enderror">
                    @error('owner_dob')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. HP Pemilik <span class="text-red-500">*</span></label>
                    <input type="text" name="owner_phone" value="{{ old('owner_phone') }}" required
                           class="w-full px-3 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 @error('owner_phone') border-red-400 @enderror"
                           placeholder="08xxxxxxxxxx">
                    @error('owner_phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kota <span class="text-red-500">*</span></label>
                    <input type="text" name="owner_city" value="{{ old('owner_city') }}" required
                           class="w-full px-3 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500"
                           placeholder="Jakarta Selatan">
                    @error('owner_city')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Provinsi <span class="text-red-500">*</span></label>
                    <input type="text" name="owner_province" value="{{ old('owner_province') }}" required
                           class="w-full px-3 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500"
                           placeholder="DKI Jakarta">
                    @error('owner_province')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap <span class="text-red-500">*</span></label>
                    <textarea name="owner_address" required rows="2"
                              class="w-full px-3 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 @error('owner_address') border-red-400 @enderror"
                              placeholder="Jl. Sudirman No. 1 RT 01/RW 02">{{ old('owner_address') }}</textarea>
                    @error('owner_address')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Foto KTP <span class="text-red-500">*</span>
                        <span class="text-gray-400 font-normal ml-1">JPG/PNG, maks. 2MB</span>
                    </label>
                    <input type="file" name="id_card_photo" accept="image/*" required
                           class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                    @error('id_card_photo')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        {{-- ── SEKSI 2: DATA TOKO ──────────────────────────────────────── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-purple-50 border-b border-purple-100 flex items-center gap-2">
                <span class="w-6 h-6 bg-purple-600 text-white text-xs font-bold rounded-full flex items-center justify-center">2</span>
                <h2 class="font-semibold text-gray-800">Informasi Toko</h2>
            </div>
            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Toko <span class="text-red-500">*</span></label>
                    <input type="text" name="store_name" value="{{ old('store_name') }}" required
                           class="w-full px-3 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 @error('store_name') border-red-400 @enderror"
                           placeholder="Toko Gadget Jaya">
                    @error('store_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Produk yang Dijual <span class="text-red-500">*</span></label>
                    <input type="text" name="store_category" value="{{ old('store_category') }}" required
                           class="w-full px-3 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500"
                           placeholder="Smartphone, Laptop, Aksesori">
                    @error('store_category')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Toko <span class="text-red-500">*</span></label>
                    <textarea name="store_description" required rows="3"
                              class="w-full px-3 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 @error('store_description') border-red-400 @enderror"
                              placeholder="Ceritakan tentang toko Anda, produk yang dijual, pengalaman, dll...">{{ old('store_description') }}</textarea>
                    @error('store_description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. HP Toko <span class="text-red-500">*</span></label>
                    <input type="text" name="store_phone" value="{{ old('store_phone') }}" required
                           class="w-full px-3 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500"
                           placeholder="08xxxxxxxxxx">
                    @error('store_phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email Toko <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <input type="email" name="store_email" value="{{ old('store_email') }}"
                           class="w-full px-3 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500"
                           placeholder="toko@email.com">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kota Toko <span class="text-red-500">*</span></label>
                    <input type="text" name="store_city" value="{{ old('store_city') }}" required
                           class="w-full px-3 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500"
                           placeholder="Bandung">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Provinsi Toko <span class="text-red-500">*</span></label>
                    <input type="text" name="store_province" value="{{ old('store_province') }}" required
                           class="w-full px-3 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500"
                           placeholder="Jawa Barat">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Toko <span class="text-red-500">*</span></label>
                    <textarea name="store_address" required rows="2"
                              class="w-full px-3 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500"
                              placeholder="Jl. Asia Afrika No. 10">{{ old('store_address') }}</textarea>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Logo Toko <span class="text-gray-400 font-normal">(opsional, JPG/PNG/WebP, maks. 2MB)</span>
                    </label>
                    <input type="file" name="store_logo" accept="image/*"
                           class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                </div>
            </div>
        </div>

        {{-- ── SEKSI 3: LEGALITAS & REKENING ───────────────────────────── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-purple-50 border-b border-purple-100 flex items-center gap-2">
                <span class="w-6 h-6 bg-purple-600 text-white text-xs font-bold rounded-full flex items-center justify-center">3</span>
                <h2 class="font-semibold text-gray-800">Legalitas & Rekening Bank</h2>
            </div>
            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        NPWP <span class="text-gray-400 font-normal">(opsional)</span>
                    </label>
                    <input type="text" name="npwp" value="{{ old('npwp') }}" maxlength="20"
                           class="w-full px-3 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500"
                           placeholder="XX.XXX.XXX.X-XXX.XXX">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        SIUP / NIB <span class="text-gray-400 font-normal">(opsional)</span>
                    </label>
                    <input type="text" name="siup_nib" value="{{ old('siup_nib') }}"
                           class="w-full px-3 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500"
                           placeholder="Nomor SIUP atau NIB">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Foto NPWP <span class="text-gray-400 font-normal">(opsional, JPG/PNG, maks. 2MB)</span>
                    </label>
                    <input type="file" name="npwp_photo" accept="image/*"
                           class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                </div>

                <div class="sm:col-span-2 border-t border-gray-100 pt-4">
                    <p class="text-sm font-semibold text-gray-700 mb-3">Rekening Pembayaran <span class="text-red-500">*</span></p>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Nama Bank</label>
                            <input type="text" name="bank_name" value="{{ old('bank_name') }}" required
                                   class="w-full px-3 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 @error('bank_name') border-red-400 @enderror"
                                   placeholder="BCA, BRI, Mandiri...">
                            @error('bank_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">No. Rekening</label>
                            <input type="text" name="bank_account_number" value="{{ old('bank_account_number') }}" required
                                   class="w-full px-3 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 @error('bank_account_number') border-red-400 @enderror"
                                   placeholder="1234567890">
                            @error('bank_account_number')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Nama Pemilik Rekening</label>
                            <input type="text" name="bank_account_name" value="{{ old('bank_account_name') }}" required
                                   class="w-full px-3 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 @error('bank_account_name') border-red-400 @enderror"
                                   placeholder="Abdul Saputra">
                            @error('bank_account_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── PERNYATAAN & SUBMIT ──────────────────────────────────────── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <label class="flex items-start gap-3 cursor-pointer">
                <input type="checkbox" required class="mt-0.5 w-4 h-4 text-purple-600 rounded border-gray-300">
                <span class="text-sm text-gray-600">
                    Saya menyatakan bahwa semua data yang saya isi adalah <strong>benar dan dapat dipertanggungjawabkan</strong>.
                    Saya menyetujui <a href="#" class="text-purple-600 hover:underline">Syarat & Ketentuan Merchant</a> GadgetHub.
                </span>
            </label>

            <div class="flex gap-3 mt-5">
                <button type="submit"
                        class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 rounded-xl text-sm transition">
                    Kirim Pendaftaran
                </button>
                <a href="{{ route('products.index') }}"
                   class="px-6 py-3 border border-gray-300 text-gray-600 hover:bg-gray-50 rounded-xl text-sm font-medium transition">
                    Batal
                </a>
            </div>
        </div>

    </form>
</div>
@endsection
