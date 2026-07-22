@extends('layouts.admin')
@section('title', 'Detail Pendaftaran — Super Admin GadgetHub')

@section('content')

{{-- Breadcrumb + Header --}}
<div class="mb-7">
    <a href="{{ route('admin.merchant-applications.index') }}"
       class="inline-flex items-center gap-1.5 text-sm text-slate-500 transition-colors hover:text-rose-600">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
        Pendaftaran Merchant
    </a>
    <div class="mt-3 flex flex-wrap items-start justify-between gap-4">
        <div>
            <p class="section-eyebrow text-rose-600">Detail Pendaftaran</p>
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">{{ $application->store_name }}</h1>
            <p class="mt-0.5 text-sm text-slate-400">Diajukan {{ $application->created_at->format('d M Y, H:i') }}</p>
        </div>
        @php
            $statusConfig = [
                'pending'  => ['class' => 'bg-amber-100 text-amber-700',    'dot' => 'bg-amber-400'],
                'approved' => ['class' => 'bg-emerald-100 text-emerald-700','dot' => 'bg-emerald-500'],
                'rejected' => ['class' => 'bg-rose-100 text-rose-700',      'dot' => 'bg-rose-500'],
            ];
            $sc = $statusConfig[$application->status] ?? $statusConfig['pending'];
        @endphp
        <span class="inline-flex items-center gap-1.5 rounded-2xl px-4 py-1.5 text-sm font-semibold {{ $sc['class'] }}">
            <span class="h-2 w-2 rounded-full {{ $sc['dot'] }}"></span>
            {{ $application->statusLabel() }}
        </span>
    </div>
</div>

<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

    {{-- ── Left: Detail sections ── --}}
    <div class="space-y-5 lg:col-span-2">

        {{-- Data Diri --}}
        <div class="card overflow-hidden">
            <div class="flex items-center gap-2 border-b border-slate-100 bg-slate-50/60 px-6 py-3.5">
                <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <h3 class="text-sm font-bold text-slate-700">Data Diri Pemilik</h3>
            </div>
            <div class="grid grid-cols-1 gap-x-6 gap-y-4 p-6 sm:grid-cols-2">
                @php
                    $ownerFields = [
                        'Nama Lengkap'   => $application->owner_name,
                        'NIK'            => $application->owner_nik,
                        'Tanggal Lahir'  => $application->owner_dob->format('d M Y'),
                        'No. HP'         => $application->owner_phone,
                    ];
                @endphp
                @foreach($ownerFields as $label => $value)
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">{{ $label }}</p>
                    <p class="mt-0.5 text-sm font-semibold text-slate-800">{{ $value }}</p>
                </div>
                @endforeach
                <div class="sm:col-span-2">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Alamat</p>
                    <p class="mt-0.5 text-sm font-semibold text-slate-800">
                        {{ $application->owner_address }}, {{ $application->owner_city }}, {{ $application->owner_province }}
                    </p>
                </div>
                @if($application->id_card_photo)
                <div class="sm:col-span-2">
                    <p class="mb-2 text-[10px] font-bold uppercase tracking-widest text-slate-400">Foto KTP</p>
                    <a href="{{ asset('storage/'.$application->id_card_photo) }}" target="_blank"
                       class="inline-block overflow-hidden rounded-2xl border border-slate-200 transition-opacity hover:opacity-90">
                        <img src="{{ asset('storage/'.$application->id_card_photo) }}"
                             class="h-36 object-cover">
                    </a>
                </div>
                @endif
            </div>
        </div>

        {{-- Data Toko --}}
        <div class="card overflow-hidden">
            <div class="flex items-center gap-2 border-b border-slate-100 bg-slate-50/60 px-6 py-3.5">
                <svg class="h-4 w-4 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                    <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9z" clip-rule="evenodd"/>
                </svg>
                <h3 class="text-sm font-bold text-slate-700">Informasi Toko</h3>
            </div>
            <div class="grid grid-cols-1 gap-x-6 gap-y-4 p-6 sm:grid-cols-2">
                @php
                    $storeFields = [
                        'Nama Toko'     => $application->store_name,
                        'Jenis Produk'  => $application->store_category,
                        'No. HP Toko'   => $application->store_phone,
                        'Email Toko'    => $application->store_email ?? '—',
                    ];
                @endphp
                @foreach($storeFields as $label => $value)
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">{{ $label }}</p>
                    <p class="mt-0.5 text-sm font-semibold text-slate-800">{{ $value }}</p>
                </div>
                @endforeach
                <div class="sm:col-span-2">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Alamat Toko</p>
                    <p class="mt-0.5 text-sm font-semibold text-slate-800">
                        {{ $application->store_address }}, {{ $application->store_city }}, {{ $application->store_province }}
                    </p>
                </div>
                <div class="sm:col-span-2">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Deskripsi</p>
                    <p class="mt-0.5 text-sm leading-relaxed text-slate-700">{{ $application->store_description }}</p>
                </div>
                @if($application->store_logo)
                <div class="sm:col-span-2">
                    <p class="mb-2 text-[10px] font-bold uppercase tracking-widest text-slate-400">Logo Toko</p>
                    <img src="{{ asset('storage/'.$application->store_logo) }}"
                         class="h-20 overflow-hidden rounded-2xl border border-slate-200 object-cover">
                </div>
                @endif
            </div>
        </div>

        {{-- Legalitas & Rekening --}}
        <div class="card overflow-hidden">
            <div class="flex items-center gap-2 border-b border-slate-100 bg-slate-50/60 px-6 py-3.5">
                <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="text-sm font-bold text-slate-700">Legalitas &amp; Rekening</h3>
            </div>
            <div class="grid grid-cols-1 gap-x-6 gap-y-4 p-6 sm:grid-cols-2">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">NPWP</p>
                    <p class="mt-0.5 text-sm font-semibold text-slate-800">{{ $application->npwp ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">SIUP / NIB</p>
                    <p class="mt-0.5 text-sm font-semibold text-slate-800">{{ $application->siup_nib ?? '—' }}</p>
                </div>

                {{-- Bank info row --}}
                <div class="sm:col-span-2">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="h-px flex-1 bg-slate-100"></div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Rekening Pembayaran</p>
                        <div class="h-px flex-1 bg-slate-100"></div>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Bank</p>
                            <p class="mt-0.5 text-sm font-semibold text-slate-800">{{ $application->bank_name }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">No. Rekening</p>
                            <p class="mt-0.5 text-sm font-semibold text-slate-800">{{ $application->bank_account_number }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Atas Nama</p>
                            <p class="mt-0.5 text-sm font-semibold text-slate-800">{{ $application->bank_account_name }}</p>
                        </div>
                    </div>
                </div>

                @if($application->npwp_photo)
                <div class="sm:col-span-2">
                    <p class="mb-2 text-[10px] font-bold uppercase tracking-widest text-slate-400">Foto NPWP</p>
                    <a href="{{ asset('storage/'.$application->npwp_photo) }}" target="_blank"
                       class="inline-block overflow-hidden rounded-2xl border border-slate-200 transition-opacity hover:opacity-90">
                        <img src="{{ asset('storage/'.$application->npwp_photo) }}"
                             class="h-36 object-cover">
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ── Right: Sidebar ── --}}
    <div class="space-y-5">

        {{-- Applicant info --}}
        <div class="card p-5">
            <p class="mb-3 text-[10px] font-bold uppercase tracking-widest text-slate-400">Pemohon</p>
            <div class="flex items-center gap-3">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($application->user->name) }}&background=4f46e5&color=fff&size=64"
                     class="avatar avatar-md flex-shrink-0">
                <div class="min-w-0">
                    <p class="truncate text-sm font-bold text-slate-800">{{ $application->user->name }}</p>
                    <p class="truncate text-xs text-slate-400">{{ $application->user->email }}</p>
                </div>
            </div>
            <div class="mt-4 space-y-1.5 border-t border-slate-100 pt-4 text-xs text-slate-400">
                <p>Diajukan: <span class="font-semibold text-slate-600">{{ $application->created_at->format('d M Y H:i') }}</span></p>
                @if($application->reviewed_at)
                <p>Direview: <span class="font-semibold text-slate-600">{{ $application->reviewed_at->format('d M Y H:i') }}</span></p>
                @endif
                @if($application->reviewer)
                <p>Oleh: <span class="font-semibold text-slate-600">{{ $application->reviewer->name }}</span></p>
                @endif
            </div>
        </div>

        {{-- Action panel (only if pending) --}}
        @if($application->isPending())
        <div class="card p-5" x-data="{ showReject: false }">
            <p class="mb-4 text-sm font-bold text-slate-800">Tindakan Review</p>

            {{-- Approve --}}
            <form action="{{ route('admin.merchant-applications.approve', $application) }}" method="POST"
                  onsubmit="return confirm('Setujui pendaftaran {{ addslashes($application->store_name) }}?')">
                @csrf @method('PATCH')
                <button type="submit"
                        class="mb-2.5 inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-emerald-600 py-3 text-sm font-bold text-white transition-colors hover:bg-emerald-700 active:scale-95">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Setujui Pendaftaran
                </button>
            </form>

            {{-- Reject toggle --}}
            <button type="button" @click="showReject = !showReject"
                    class="inline-flex w-full items-center justify-center gap-2 rounded-2xl border border-rose-200 bg-rose-50 py-3 text-sm font-semibold text-rose-600 transition-colors hover:bg-rose-100 active:scale-95">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Tolak Pendaftaran
            </button>

            {{-- Reject form --}}
            <div x-show="showReject" x-cloak
                 x-transition:enter="transition duration-200 ease-out"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="mt-4 border-t border-slate-100 pt-4">
                <form action="{{ route('admin.merchant-applications.reject', $application) }}" method="POST">
                    @csrf @method('PATCH')
                    <div class="form-group mb-3">
                        <label class="input-label text-xs">Alasan Penolakan <span class="text-rose-500">*</span></label>
                        <textarea name="rejection_reason" required rows="3"
                                  placeholder="Tulis alasan penolakan yang jelas…"
                                  class="input-field resize-none text-sm"></textarea>
                    </div>
                    <button type="submit"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-rose-600 py-2.5 text-sm font-bold text-white transition-colors hover:bg-rose-700 active:scale-95">
                        Kirim Penolakan
                    </button>
                </form>
            </div>
        </div>

        @elseif($application->isRejected())
        {{-- Rejection reason display --}}
        <div class="card overflow-hidden">
            <div class="flex items-center gap-2 border-b border-rose-100 bg-rose-50/60 px-5 py-3.5">
                <svg class="h-4 w-4 text-rose-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm font-bold text-rose-700">Alasan Penolakan</p>
            </div>
            <div class="p-5">
                <p class="text-sm leading-relaxed text-slate-700">{{ $application->rejection_reason ?? '—' }}</p>
            </div>
        </div>

        @elseif($application->isApproved())
        {{-- Approved badge --}}
        <div class="card overflow-hidden">
            <div class="flex items-center gap-2 border-b border-emerald-100 bg-emerald-50/60 px-5 py-3.5">
                <svg class="h-4 w-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm font-bold text-emerald-700">Pendaftaran Disetujui</p>
            </div>
            <div class="p-5">
                <p class="text-sm text-slate-600">
                    Toko <strong>{{ $application->store_name }}</strong> telah disetujui dan pemiliknya sudah aktif sebagai Merchant.
                </p>
            </div>
        </div>
        @endif

    </div>
</div>

@push('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush

@endsection
