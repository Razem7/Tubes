@extends('layouts.admin')
@section('title', 'Kelola User — Super Admin GadgetHub')

@section('content')

{{-- Header --}}
<div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <p class="section-eyebrow text-rose-600">Manajemen</p>
        <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Kelola User</h1>
        <p class="mt-0.5 text-sm text-slate-500">Manajemen user biasa dan merchant</p>
    </div>
    <div class="flex items-center gap-3">
        <span class="badge badge-indigo">{{ $users->total() }} user</span>
    </div>
</div>

{{-- Filter & Search --}}
<div class="card mb-6 p-4">
    <form action="{{ route('admin.users') }}" method="GET"
          class="flex flex-wrap items-center gap-3">
        <div class="relative flex-1 min-w-[200px]">
            <div class="pointer-events-none absolute inset-y-0 left-3.5 flex items-center text-slate-400">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/>
                </svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari nama atau email…"
                   class="input-field py-2.5 pl-10">
        </div>
        <select name="role" class="input-field w-auto min-w-[150px] py-2.5">
            <option value="">Semua Role</option>
            <option value="user"     {{ request('role') === 'user'     ? 'selected' : '' }}>User Biasa</option>
            <option value="merchant" {{ request('role') === 'merchant' ? 'selected' : '' }}>Merchant</option>
        </select>
        <button type="submit"
                class="inline-flex items-center gap-2 rounded-2xl bg-rose-600 px-5 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-rose-700 active:scale-95">
            Cari
        </button>
        @if(request('search') || request('role'))
        <a href="{{ route('admin.users') }}" class="btn-secondary py-2.5 px-4 text-sm">Reset</a>
        @endif
    </form>
</div>

{{-- Table --}}
<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th class="pl-5">Nama</th>
                    <th>Email</th>
                    <th class="hidden sm:table-cell">No HP</th>
                    <th>Role</th>
                    <th class="hidden md:table-cell text-center">Produk</th>
                    <th class="hidden md:table-cell">Bergabung</th>
                    <th class="pr-5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    {{-- Avatar + Name --}}
                    <td class="pl-5">
                        <div class="flex items-center gap-3">
                            <img src="{{ $user->profile_photo_url
                                ? asset('storage/'.$user->profile_photo_url)
                                : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=4f46e5&color=fff&size=64' }}"
                                 class="avatar avatar-sm flex-shrink-0">
                            <span class="max-w-[120px] truncate text-sm font-semibold text-slate-800"
                                  title="{{ $user->name }}">{{ $user->name }}</span>
                        </div>
                    </td>

                    {{-- Email --}}
                    <td class="max-w-[180px]">
                        <span class="truncate text-sm text-slate-600" title="{{ $user->email }}">
                            {{ $user->email }}
                        </span>
                    </td>

                    {{-- Phone --}}
                    <td class="hidden sm:table-cell text-sm text-slate-500">
                        {{ $user->phone_number ?? '—' }}
                    </td>

                    {{-- Role badge --}}
                    <td>
                        @if($user->isMerchant())
                            <span class="badge badge-purple whitespace-nowrap">Merchant</span>
                        @else
                            <span class="badge badge-indigo whitespace-nowrap">User Biasa</span>
                        @endif
                    </td>

                    {{-- Product count --}}
                    <td class="hidden md:table-cell text-center">
                        <span class="text-sm font-semibold text-slate-700">{{ $user->products->count() }}</span>
                    </td>

                    {{-- Join date --}}
                    <td class="hidden md:table-cell whitespace-nowrap text-sm text-slate-400">
                        {{ $user->created_at->format('d/m/Y') }}
                    </td>

                    {{-- Actions --}}
                    <td class="pr-5 text-right">
                        <div class="inline-flex items-center justify-end gap-1.5 flex-wrap">
                            @if($user->isUser())
                            <form action="{{ route('admin.users.promote', $user) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit"
                                        onclick="return confirm('Jadikan {{ addslashes($user->name) }} sebagai Merchant?')"
                                        class="whitespace-nowrap rounded-xl border border-purple-200 bg-purple-50 px-3 py-1.5 text-xs font-semibold text-purple-700 transition-colors hover:bg-purple-100 active:scale-95">
                                    Jadi Merchant
                                </button>
                            </form>
                            @elseif($user->isMerchant())
                            <form action="{{ route('admin.users.demote', $user) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit"
                                        onclick="return confirm('Turunkan {{ addslashes($user->name) }} menjadi User biasa?')"
                                        class="whitespace-nowrap rounded-xl border border-slate-200 bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-600 transition-colors hover:bg-slate-200 active:scale-95">
                                    Jadi User
                                </button>
                            </form>
                            @endif
                            <form action="{{ route('admin.users.delete', $user) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('Hapus {{ addslashes($user->name) }}? Semua produknya akan ikut terhapus!')"
                                        class="rounded-xl border border-rose-200 bg-rose-50 px-3 py-1.5 text-xs font-semibold text-rose-600 transition-colors hover:bg-rose-100 active:scale-95">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-16 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100">
                                <svg class="h-6 w-6 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <p class="text-sm font-semibold text-slate-500">
                                {{ request('search') || request('role') ? 'User tidak ditemukan' : 'Belum ada user' }}
                            </p>
                            @if(request('search') || request('role'))
                            <a href="{{ route('admin.users') }}" class="text-xs font-semibold text-rose-600 hover:underline">Reset filter</a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($users->hasPages())
<div class="mt-6 flex justify-center border-t border-slate-100 pt-6">
    {{ $users->withQueryString()->links() }}
</div>
@endif

@endsection
