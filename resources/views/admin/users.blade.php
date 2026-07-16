@extends('layouts.admin')

@section('title', 'GadgetHub - Kelola User')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Kelola User</h2>
    <p class="text-sm text-gray-500 mt-1">Manajemen user biasa dan merchant</p>
</div>

<!-- Filter & Search -->
<div class="bg-white rounded-xl shadow-sm p-4 mb-6">
    <form action="{{ route('admin.users') }}" method="GET" class="flex flex-wrap gap-2">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Cari nama atau email..."
               class="flex-1 min-w-[200px] px-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        <select name="role" class="px-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Semua Role</option>
            <option value="user"     {{ request('role') === 'user'     ? 'selected' : '' }}>User Biasa</option>
            <option value="merchant" {{ request('role') === 'merchant' ? 'selected' : '' }}>Merchant</option>
        </select>
        <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm hover:bg-blue-700">Cari</button>
        <a href="{{ route('admin.users') }}" class="bg-gray-200 text-gray-700 px-5 py-2 rounded-lg text-sm hover:bg-gray-300">Reset</a>
    </form>
</div>

<!-- Table -->
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase w-40">Nama</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Email</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase w-32">No HP</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase w-24">Role</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase w-20">Produk</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase w-28">Bergabung</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase w-36">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">
                            <img src="{{ $user->profile_photo_url ? asset('storage/' . $user->profile_photo_url) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=6366f1&color=fff' }}"
                                 class="w-8 h-8 rounded-full object-cover flex-shrink-0">
                            <span class="text-sm font-medium text-gray-800 truncate max-w-[100px]" title="{{ $user->name }}">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-600 truncate max-w-[180px]" title="{{ $user->email }}">{{ $user->email }}</td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $user->phone_number ?? '-' }}</td>
                    <td class="px-4 py-3">
                        @if($user->isMerchant())
                            <span class="bg-purple-100 text-purple-700 text-xs font-semibold px-2 py-1 rounded-full whitespace-nowrap">Merchant</span>
                        @else
                            <span class="bg-blue-100 text-blue-700 text-xs font-semibold px-2 py-1 rounded-full whitespace-nowrap">User Biasa</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-600 text-center">{{ $user->products->count() }}</td>
                    <td class="px-4 py-3 text-sm text-gray-500 whitespace-nowrap">{{ $user->created_at->format('d/m/Y') }}</td>
                    <td class="px-4 py-3">
                        <div class="flex flex-wrap items-center gap-1">
                            @if($user->isUser())
                                <form action="{{ route('admin.users.promote', $user) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit"
                                            onclick="return confirm('Jadikan {{ $user->name }} sebagai Merchant?')"
                                            class="bg-purple-600 text-white text-xs px-2.5 py-1.5 rounded-lg hover:bg-purple-700 whitespace-nowrap">
                                        Jadi Merchant
                                    </button>
                                </form>
                            @elseif($user->isMerchant())
                                <form action="{{ route('admin.users.demote', $user) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit"
                                            onclick="return confirm('Turunkan {{ $user->name }} menjadi User biasa?')"
                                            class="bg-gray-500 text-white text-xs px-2.5 py-1.5 rounded-lg hover:bg-gray-600 whitespace-nowrap">
                                        Jadi User
                                    </button>
                                </form>
                            @endif
                            <form action="{{ route('admin.users.delete', $user) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('Hapus {{ $user->name }}? Semua produknya akan ikut terhapus!')"
                                        class="bg-red-600 text-white text-xs px-2.5 py-1.5 rounded-lg hover:bg-red-700">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-10 text-center text-sm text-gray-400">Tidak ada user ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">{{ $users->links() }}</div>
@endsection
