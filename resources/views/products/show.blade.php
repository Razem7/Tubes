@extends('layouts.app')

@section('title', $product->title . ' - GadgetHub')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-6">

    @php
        $conditionMap    = ['new' => 'Baru', 'like_new' => 'Seperti Baru', 'good' => 'Baik', 'fair' => 'Cukup Baik'];
        $conditionColors = [
            'new'      => 'background:#dcfce7;color:#15803d;',
            'like_new' => 'background:#dbeafe;color:#1d4ed8;',
            'good'     => 'background:#fef9c3;color:#a16207;',
            'fair'     => 'background:#ffedd5;color:#c2410c;',
        ];
        $firstPhoto = $product->photos->first();
    @endphp

    {{-- Breadcrumb --}}
    <nav class="text-xs text-gray-400 mb-4 flex items-center gap-1.5 flex-wrap">
        <a href="{{ route('products.index') }}" class="hover:text-blue-600">Beranda</a>
        <span>/</span>
        @if($product->category)
        <a href="{{ route('products.index', ['category_id' => $product->category->id]) }}" class="hover:text-blue-600">{{ $product->category->name }}</a>
        <span>/</span>
        @endif
        <span class="text-gray-600 truncate max-w-xs">{{ $product->title }}</span>
    </nav>

    {{-- Main grid: foto kiri, info kanan --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">

        {{-- ===== KIRI: Foto ===== --}}
        <div>
            {{-- Main photo --}}
            <div class="rounded-2xl overflow-hidden bg-white border border-gray-200 shadow-sm"
                 style="aspect-ratio:4/3; display:flex; align-items:center; justify-content:center; position:relative;">
                @if($firstPhoto && $firstPhoto->photo_url)
                    <img id="mainImage"
                         src="{{ asset($firstPhoto->photo_url) }}"
                         alt="{{ $product->title }}"
                         style="width:100%; height:100%; object-fit:contain; background:#f9fafb;"
                         onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                    <div style="display:none; flex-direction:column; align-items:center; justify-content:center; width:100%; height:100%; color:#d1d5db;">
                        <svg style="width:48px;height:48px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span style="font-size:13px;margin-top:8px;color:#9ca3af;">Belum ada foto</span>
                    </div>
                @else
                    <div style="display:flex; flex-direction:column; align-items:center; justify-content:center; color:#d1d5db; width:100%; height:100%;">
                        <svg style="width:56px;height:56px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span style="font-size:13px;margin-top:8px;color:#9ca3af;">Belum ada foto</span>
                    </div>
                @endif

                @if($product->is_sold)
                <div style="position:absolute;inset:0;background:rgba(0,0,0,.45);display:flex;align-items:center;justify-content:center;">
                    <span style="background:#dc2626;color:#fff;font-weight:700;font-size:14px;padding:6px 20px;border-radius:999px;letter-spacing:.05em;">TERJUAL</span>
                </div>
                @endif
            </div>

            {{-- Thumbnails --}}
            @if($product->photos->count() > 1)
            <div style="display:flex;gap:8px;margin-top:10px;overflow-x:auto;padding-bottom:4px;">
                @foreach($product->photos as $i => $photo)
                @if($photo->photo_url)
                <img src="{{ asset($photo->photo_url) }}"
                     alt="{{ $product->title }}"
                     onclick="changeMainImage('{{ asset($photo->photo_url) }}', this)"
                     style="width:60px;height:60px;object-fit:cover;border-radius:10px;cursor:pointer;flex-shrink:0;border:2px solid {{ $i===0 ? '#3b82f6' : '#e5e7eb' }};transition:border-color .2s;"
                     onmouseover="if(this.style.borderColor!='rgb(59, 130, 246)')this.style.borderColor='#93c5fd'"
                     onmouseout="if(this.style.borderColor!='rgb(59, 130, 246)')this.style.borderColor='#e5e7eb'">
                @endif
                @endforeach
            </div>
            @endif

            {{-- Description (mobile & desktop, shown below photo on mobile, stays left col on desktop) --}}
            <div class="mt-4 bg-white rounded-2xl border border-gray-200 shadow-sm p-5 hidden md:block">
                <p class="font-semibold text-gray-900 mb-2" style="font-size:15px;">Deskripsi</p>
                <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line">{{ $product->description }}</p>
            </div>
        </div>

        {{-- ===== KANAN: Info + CTA ===== --}}
        <div style="display:flex;flex-direction:column;gap:16px;">

            {{-- Price card --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm" style="padding: 20px 24px;">
                <p style="font-size:26px;font-weight:800;color:#2563eb;line-height:1.2;">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </p>
                <p class="font-semibold text-gray-800 mt-1" style="font-size:14px;line-height:1.5;">{{ $product->title }}</p>

                {{-- Tags --}}
                <div style="display:flex;flex-wrap:wrap;gap:6px;margin-top:10px;">
                    @if($product->category)
                    <span style="font-size:11px;padding:3px 10px;border-radius:999px;background:#dbeafe;color:#1d4ed8;font-weight:600;border:1px solid #bfdbfe;">
                        {{ $product->category->name }}
                    </span>
                    @endif
                    <span style="font-size:11px;padding:3px 10px;border-radius:999px;font-weight:600;{{ $conditionColors[$product->condition] ?? 'background:#f3f4f6;color:#6b7280;' }}">
                        {{ $conditionMap[$product->condition] ?? $product->condition }}
                    </span>
                    <span style="font-size:11px;padding:3px 10px;border-radius:999px;background:#f9fafb;color:#6b7280;border:1px solid #e5e7eb;display:inline-flex;align-items:center;gap:3px;">
                        <svg style="width:11px;height:11px;" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                        </svg>
                        {{ $product->location }}
                    </span>
                </div>

                <hr style="margin:14px 0;border-color:#f3f4f6;">

                {{-- Action buttons --}}
                @if($product->is_sold)
                <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:10px;text-align:center;">
                    <p style="color:#dc2626;font-weight:600;font-size:13px;">Produk ini sudah terjual</p>
                </div>
                @else
                <div style="display:flex;flex-direction:column;gap:8px;">
                    @auth
                        @if($product->user_id === auth()->id())
                        <a href="{{ route('products.edit', $product) }}"
                           style="display:inline-flex;align-items:center;justify-content:center;gap:7px;padding:9px 20px;border-radius:10px;background:linear-gradient(135deg,#2563eb,#3b82f6);color:#fff;font-size:13px;font-weight:600;text-decoration:none;transition:opacity .2s;align-self:flex-start;"
                           onmouseover="this.style.opacity='.88'" onmouseout="this.style.opacity='1'">
                            <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Edit Produk
                        </a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    style="display:inline-flex;align-items:center;justify-content:center;gap:7px;padding:9px 20px;border-radius:10px;border:1.5px solid #fca5a5;background:#fff;color:#ef4444;font-size:13px;font-weight:500;cursor:pointer;transition:background .2s;"
                                    onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background='#fff'">
                                <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                Hapus Produk
                            </button>
                        </form>
                        @else
                        <div style="display:flex;gap:8px;flex-wrap:wrap;">
                            <a href="{{ route('products.checkout', $product) }}"
                               style="display:inline-flex;align-items:center;gap:7px;padding:9px 20px;border-radius:10px;background:linear-gradient(135deg,#059669,#10b981);color:#fff;font-size:13px;font-weight:700;text-decoration:none;transition:opacity .2s;"
                               onmouseover="this.style.opacity='.88'" onmouseout="this.style.opacity='1'">
                                <svg style="width:15px;height:15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                Beli Sekarang
                            </a>
                            <form action="{{ route('chats.start', $product) }}" method="POST" style="margin:0;">
                                @csrf
                                <button type="submit"
                                        style="display:inline-flex;align-items:center;gap:7px;padding:9px 20px;border-radius:10px;border:2px solid #3b82f6;background:#fff;color:#2563eb;font-size:13px;font-weight:700;cursor:pointer;transition:background .2s;"
                                        onmouseover="this.style.background='#eff6ff'" onmouseout="this.style.background='#fff'">
                                    <svg style="width:15px;height:15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                    Chat Penjual
                                </button>
                            </form>
                        </div>
                        <form action="{{ route('favorites.toggle', $product) }}" method="POST" style="margin:0;">
                            @csrf
                            <button type="submit"
                                    style="display:inline-flex;align-items:center;gap:6px;padding:7px 16px;border-radius:10px;border:1.5px solid #e5e7eb;background:#fff;color:#6b7280;font-size:12px;cursor:pointer;transition:background .2s;"
                                    onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='#fff'">
                                @if($isFavorited)
                                <svg style="width:14px;height:14px;color:#ef4444;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/></svg>
                                Hapus Favorit
                                @else
                                <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                Tambah Favorit
                                @endif
                            </button>
                        </form>
                        @endif
                    @else
                        <div style="display:flex;gap:8px;flex-wrap:wrap;">
                            <button onclick="showLoginModal('Login untuk membeli produk ini.')"
                                    style="display:inline-flex;align-items:center;gap:7px;padding:9px 20px;border-radius:10px;background:linear-gradient(135deg,#059669,#10b981);color:#fff;font-size:13px;font-weight:700;border:none;cursor:pointer;transition:opacity .2s;"
                                    onmouseover="this.style.opacity='.88'" onmouseout="this.style.opacity='1'">
                                <svg style="width:15px;height:15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                Beli Sekarang
                            </button>
                            <button onclick="showLoginModal('Login untuk chat dengan penjual.')"
                                    style="display:inline-flex;align-items:center;gap:7px;padding:9px 20px;border-radius:10px;border:2px solid #3b82f6;background:#fff;color:#2563eb;font-size:13px;font-weight:700;cursor:pointer;transition:background .2s;"
                                    onmouseover="this.style.background='#eff6ff'" onmouseout="this.style.background='#fff'">
                                <svg style="width:15px;height:15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                Chat Penjual
                            </button>
                        </div>
                        <button onclick="showLoginModal('Login untuk menyimpan ke favorit.')"
                                style="display:inline-flex;align-items:center;gap:6px;padding:7px 16px;border-radius:10px;border:1.5px solid #e5e7eb;background:#fff;color:#6b7280;font-size:12px;cursor:pointer;transition:background .2s;"
                                onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='#fff'">
                            <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                            Tambah Favorit
                        </button>
                    @endauth
                </div>
                @endif
            </div>

            {{-- Seller --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4">
                <p style="font-size:11px;font-weight:600;color:#9ca3af;text-transform:uppercase;letter-spacing:.08em;margin-bottom:10px;">Penjual</p>
                <div style="display:flex;align-items:center;gap:12px;">
                    @if($product->user->profile_photo_url)
                        <img src="{{ asset('storage/' . $product->user->profile_photo_url) }}"
                             alt="{{ $product->user->name }}"
                             style="width:42px;height:42px;border-radius:50%;object-fit:cover;border:2px solid #e5e7eb;flex-shrink:0;">
                    @else
                        <div style="width:42px;height:42px;border-radius:50%;background:linear-gradient(135deg,#2563eb,#3b82f6);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:16px;flex-shrink:0;">
                            {{ strtoupper(substr($product->user->name, 0, 1)) }}
                        </div>
                    @endif
                    <div style="min-width:0;">
                        <p style="font-weight:600;color:#1f2937;font-size:14px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $product->user->name }}</p>
                        @if($product->user->phone_verified)
                        <p style="font-size:11px;color:#16a34a;display:flex;align-items:center;gap:4px;margin-top:2px;">
                            <svg style="width:12px;height:12px;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            Terverifikasi
                        </p>
                        @else
                        <p style="font-size:11px;color:#9ca3af;margin-top:2px;">Member GadgetHub</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Detail Produk --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm" style="padding: 20px 24px;">
                <p style="font-size:14px;font-weight:600;color:#111827;margin-bottom:12px;">Detail Produk</p>
                <div style="font-size:13px;">
                    <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #f9fafb;">
                        <span style="color:#6b7280;">Kondisi</span>
                        <span style="font-weight:600;padding:2px 10px;border-radius:999px;font-size:11px;{{ $conditionColors[$product->condition] ?? 'background:#f3f4f6;color:#6b7280;' }}">
                            {{ $conditionMap[$product->condition] ?? $product->condition }}
                        </span>
                    </div>
                    @if($product->brand)
                    <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid #f9fafb;">
                        <span style="color:#6b7280;">Brand</span>
                        <span style="font-weight:600;color:#111827;">{{ $product->brand }}</span>
                    </div>
                    @endif
                    @if($product->model)
                    <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid #f9fafb;">
                        <span style="color:#6b7280;">Model</span>
                        <span style="font-weight:600;color:#111827;">{{ $product->model }}</span>
                    </div>
                    @endif
                    @if($product->category)
                    <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid #f9fafb;">
                        <span style="color:#6b7280;">Kategori</span>
                        <span style="font-weight:600;color:#111827;">{{ $product->category->name }}</span>
                    </div>
                    @endif
                    <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;">
                        <span style="color:#6b7280;">Lokasi</span>
                        <span style="font-weight:600;color:#111827;">{{ $product->location }}</span>
                    </div>
                </div>
            </div>

            {{-- Safety Tips --}}
            <div style="background:#fffbeb;border:1px solid #fde68a;border-radius:16px;padding:18px 24px;">
                <p style="font-size:12px;font-weight:700;color:#92400e;display:flex;align-items:center;gap:6px;margin-bottom:8px;">
                    <svg style="width:14px;height:14px;flex-shrink:0;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    Tips Keamanan
                </p>
                <ul style="font-size:12px;color:#b45309;display:flex;flex-direction:column;gap:5px;">
                    <li>• Gunakan rekber untuk keamanan transaksi</li>
                    <li>• Periksa kondisi barang sebelum membayar</li>
                    <li>• Jangan transfer ke rekening tidak dikenal</li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Description on mobile (shown below the grid) --}}
    <div class="mt-4 bg-white rounded-2xl border border-gray-200 shadow-sm p-5 md:hidden">
        <p class="font-semibold text-gray-900 mb-2" style="font-size:15px;">Deskripsi</p>
        <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line">{{ $product->description }}</p>
    </div>

</div>

@push('scripts')
<script>
function changeMainImage(src, thumb) {
    if (!src) return;
    var main = document.getElementById('mainImage');
    if (main) main.src = src;
    document.querySelectorAll('[onclick^="changeMainImage"]').forEach(function(el) {
        el.style.borderColor = '#e5e7eb';
    });
    if (thumb) thumb.style.borderColor = '#3b82f6';
}
</script>
@endpush

@endsection
