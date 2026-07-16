@extends('layouts.admin')

@section('title', 'Detail Pendaftaran - Super Admin GadgetHub')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.merchant-applications.index') }}" class="text-sm text-gray-500 hover:text-red-600 flex items-center gap-1 mb-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali
    </a>
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Detail Pendaftaran</h2>
            <p class="text-sm text-gray-500 mt-1">{{ $application->store_name }} &middot; {{ $application->created_at->format('d M Y') }}</p>
        </div>
        @php $colors = ['pending'=>'yellow','approved'=>'green','rejected'=>'red']; $c = $colors[$application->status]; @endphp
        <span class="text-sm font-semibold px-4 py-1.5 rounded-full bg-{{ $c }}-100 text-{{ $c }}-700">
            {{ $application->statusLabel() }}
        </span>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Detail Data --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Data Diri --}}
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-3 bg-gray-50 border-b font-semibold text-sm text-gray-700">Data Diri Pemilik</div>
            <div class="p-6 grid grid-cols-2 gap-4 text-sm">
                <div><p class="text-xs text-gray-400">Nama Lengkap</p><p class="font-medium text-gray-800">{{ $application->owner_name }}</p></div>
                <div><p class="text-xs text-gray-400">NIK</p><p class="font-medium text-gray-800">{{ $application->owner_nik }}</p></div>
                <div><p class="text-xs text-gray-400">Tanggal Lahir</p><p class="font-medium text-gray-800">{{ $application->owner_dob->format('d M Y') }}</p></div>
                <div><p class="text-xs text-gray-400">No. HP</p><p class="font-medium text-gray-800">{{ $application->owner_phone }}</p></div>
                <div class="col-span-2"><p class="text-xs text-gray-400">Alamat</p><p class="font-medium text-gray-800">{{ $application->owner_address }}, {{ $application->owner_city }}, {{ $application->owner_province }}</p></div>
                @if($application->id_card_photo)
                <div class="col-span-2">
                    <p class="text-xs text-gray-400 mb-2">Foto KTP</p>
                    <a href="{{ asset('storage/' . $application->id_card_photo) }}" target="_blank">
                        <img src="{{ asset('storage/' . $application->id_card_photo) }}" class="h-32 rounded-lg border object-cover hover:opacity-90">
                    </a>
                </div>
                @endif
            </div>
        </div>

        {{-- Data Toko --}}
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-3 bg-gray-50 border-b font-semibold text-sm text-gray-700">Informasi Toko</div>
            <div class="p-6 grid grid-cols-2 gap-4 text-sm">
                <div><p class="text-xs text-gray-400">Nama Toko</p><p class="font-medium text-gray-800">{{ $application->store_name }}</p></div>
                <div><p class="text-xs text-gray-400">Jenis Produk</p><p class="font-medium text-gray-800">{{ $application->store_category }}</p></div>
                <div><p class="text-xs text-gray-400">No. HP Toko</p><p class="font-medium text-gray-800">{{ $application->store_phone }}</p></div>
                <div><p class="text-xs text-gray-400">Email Toko</p><p class="font-medium text-gray-800">{{ $application->store_email ?? '-' }}</p></div>
                <div class="col-span-2"><p class="text-xs text-gray-400">Alamat Toko</p><p class="font-medium text-gray-800">{{ $application->store_address }}, {{ $application->store_city }}, {{ $application->store_province }}</p></div>
                <div class="col-span-2"><p class="text-xs text-gray-400">Deskripsi</p><p class="text-gray-700">{{ $application->store_description }}</p></div>
                @if($application->store_logo)
                <div class="col-span-2">
                    <p class="text-xs text-gray-400 mb-2">Logo Toko</p>
                    <img src="{{ asset('storage/' . $application->store_logo) }}" class="h-20 rounded-lg border object-cover">
                </div>
                @endif
            </div>
        </div>

        {{-- Legalitas --}}
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-3 bg-gray-50 border-b font-semibold text-sm text-gray-700">Legalitas & Rekening</div>
            <div class="p-6 grid grid-cols-2 gap-4 text-sm">
                <div><p class="text-xs text-gray-400">NPWP</p><p class="font-medium text-gray-800">{{ $application->npwp ?? '-' }}</p></div>
                <div><p class="text-xs text-gray-400">SIUP / NIB</p><p class="font-medium text-gray-800">{{ $application->siup_nib ?? '-' }}</p></div>
                <div><p class="text-xs text-gray-400">Bank</p><p class="font-medium text-gray-800">{{ $application->bank_name }}</p></div>
                <div><p class="text-xs text-gray-400">No. Rekening</p><p class="font-medium text-gray-800">{{ $application->bank_account_number }}</p></div>
                <div class="col-span-2"><p class="text-xs text-gray-400">Atas Nama</p><p class="font-medium text-gray-800">{{ $application->bank_account_name }}</p></div>
                @if($application->npwp_photo)
                <div class="col-span-2">
                    <p class="text-xs text-gray-400 mb-2">Foto NPWP</p>
                    <a href="{{ asset('storage/' . $application->npwp_photo) }}" target="_blank">
                        <img src="{{ asset('storage/' . $application->npwp_photo) }}" class="h-32 rounded-lg border object-cover hover:opacity-90">
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Sidebar Action --}}
    <div class="space-y-5">

        {{-- Info Pemohon --}}
        <div class="bg-white rounded-xl shadow-sm p-5">
            <p class="text-xs text-gray-400 font-medium uppercase mb-3">Pemohon</p>
            <div class="flex items-center gap-3">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($application->user->name) }}&background=6366f1&color=fff"
                     class="w-10 h-10 rounded-full">
                <div>
                    <p class="text-sm font-semibold text-gray-800">{{ $application->user->name }}</p>
                    <p class="text-xs text-gray-500">{{ $application->user->email }}</p>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-3">Daftar: {{ $application->created_at->format('d M Y H:i') }}</p>
            @if($application->reviewed_at)
            <p class="text-xs text-gray-400">Direview: {{ $application->reviewed_at->format('d M Y H:i') }}</p>
            @endif
            @if($application->reviewer)
            <p class="text-xs text-gray-400">Oleh: {{ $application->reviewer->name }}</p>
            @endif
        </div>

        @if($application->isPending())
        {{-- Action: Approve --}}
        <div class="bg-white rounded-xl shadow-sm p-5">
            <p class="text-sm font-semibold text-gray-800 mb-3">Tindakan</p>
            <form action="{{ route('admin.merchant-applications.approve', $application) }}" method="POST"
                  onsubmit="return confirm('Setujui pendaftaran {{ addslashes($application->store_name) }}?')">
                @csrf @method('PATCH')
                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white text-sm font-semibold py-2.5 rounded-lg mb-2">
                    ✓ Setujui Pendaftaran
                </button>
            </form>

            {{-- Reject form --}}
            <div x-data="{ open: false }">
                <button @click="open = !open"
                        class="w-full border border-red-300 text-red-600 hover:bg-red-50 text-sm font-medium py-2.5 rounded-lg">
                    ✕ Tolak Pendaftaran
                </button>
                <div x-show="open" class="mt-3">
                    <form action="{{ route('admin.merchant-applications.reject', $application) }}" method="POST">
                        @csrf @method('PATCH')
                        <textarea name="rejection_reason" required rows="3" placeholder="Tulis alasan penolakan..."
                                  class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-400 mb-2"></textarea>
                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white text-sm font-semibold py-2 rounded-lg">
                            Kirim Penolakan
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @elseif($application->isRejected())
        <div class="bg-red-50 border border-red-200 rounded-xl p-5">
            <p class="text-xs font-semibold text-red-600 mb-1">Alasan Penolakan</p>
            <p class="text-sm text-red-700">{{ $application->rejection_reason ?? '-' }}</p>
        </div>
        @endif
    </div>

</div>

@push('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush
@endsection
