@extends('layouts.admin')

@section('title', 'Kelola User - Admin')

@section('content')
<div class="mb-6">
    <h2 class="text-3xl font-bold">Kelola User</h2>
</div>

<!-- Search -->
<div class="bg-white rounded-lg shadow p-4 mb-6">
    <form action="{{ route('admin.users') }}" method="GET" class="flex gap-2">
        <input type="text" 
               name="search" 
               value="{{ request('search') }}"
               placeholder="Cari user..."
               class="flex-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
            Cari
        </button>
        <a href="{{ route('admin.users') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400">
            Reset
        </a>
    </form>
</div>

<!-- Users Table -->
<div class="bg-white rounded-lg shadow">
    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b">
                        <th class="text-left py-3">Foto</th>
                        <th class="text-left py-3">Nama</th>
                        <th class="text-left py-3">Email</th>
                        <th class="text-left py-3">No HP</th>
                        <th class="text-left py-3">Total Produk</th>
                        <th class="text-left py-3">Bergabung</th>
                        <th class="text-left py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr class="border-b">
                        <td class="py-3">
                            <img src="{{ $user->profile_photo_url ? asset('storage/' . $user->profile_photo_url) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}" 
                                 alt="{{ $user->name }}"
                                 class="w-12 h-12 rounded-full object-cover">
                        </td>
                        <td class="py-3">{{ $user->name }}</td>
                        <td class="py-3">{{ $user->email }}</td>
                        <td class="py-3">{{ $user->phone_number ?? '-' }}</td>
                        <td class="py-3">{{ $user->products->count() }}</td>
                        <td class="py-3">{{ $user->created_at->format('d/m/Y') }}</td>
                        <td class="py-3">
                            <form action="{{ route('admin.users.delete', $user) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini? Semua produknya juga akan terhapus!')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-sm">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-6 text-gray-500">
                            Tidak ada user ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $users->links() }}
</div>
@endsection
