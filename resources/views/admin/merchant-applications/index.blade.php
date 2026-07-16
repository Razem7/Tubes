@extends('layouts.admin')

@section('title', 'Pendaftaran Merchant - Super Admin GadgetHub')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Pendaftaran Merchant</h2>
    <p class="text-sm text-gray-500 mt-1">Review dan setujui pendaftaran merchant baru</p>
</div>

{{-- Summary --}}
<div class="grid grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-yellow-500">
        <p class="text-xs text-gray-500 font-medium uppercase">Menunggu</p>
        <p class="text-3xl font-bold text-yellow-600 mt-1">{{ $counts['pending'] }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-green-500">
        <p class="text-xs text-gray-500 font-medium uppercase">Disetujui</p>
        <p class="text-3xl font-bold text-green-600 mt-1">{{ $counts['approved'] }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-red-500">
        <p class="text-xs text-gray-500 font-medium uppercase">Ditolak</p>
        <p class="text-3xl font-bold text-red-600 mt-1">{{ $counts['rejected'] }}</p>
    </div>
</div>

{{-- Filter --}}
<div class="bg-white rounded-xl shadow-sm p-4 mb-6">
    <form action="{{ route('admin.merchant-applications.index') }}" method="GET" class="flex gap-2">
        <select name="status" class="px-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-400">
            <option value="">Semua Status</option>
            <option value="pending"  {{ request('status') === 'pending'  ? 'selected' : '' }}>Menunggu</option>
            <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui</option>
            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
        </select>
        <button type="submit" class="bg-red-600 text-white px-5 py-2 rounded-lg text-sm hover:bg-red-700">Filter</button>
        <a href="{{ route('admin.merchant-applications.index') }}" class="bg-gray-200 text-gray-700 px-5 py-2 rounded-lg text-sm hover:bg-gray-300">Reset</a>
    </form>
</div>

{{-- Table --}}
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Pemohon</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Nama Toko</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Jenis Produk</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($applications as $app)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($app->user->name) }}&background=6366f1&color=fff"
                                 class="w-8 h-8 rounded-full flex-shrink-0">
                            <div>
                                <p class="text-sm font-medium text-gray-800">{{ $app->user->name }}</p>
                                <p class="text-xs text-gray-400">{{ $app->user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $app->store_name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $app->store_category }}</td>
                    <td class="px-6 py-4">
                        @php $colors = ['pending'=>'yellow','approved'=>'green','rejected'=>'red']; $c = $colors[$app->status]; @endphp
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-{{ $c }}-100 text-{{ $c }}-700">
                            {{ $app->statusLabel() }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $app->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.merchant-applications.show', $app) }}"
                           class="text-sm text-blue-600 hover:underline font-medium">Detail →</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-10 text-center text-sm text-gray-400">Belum ada pendaftaran.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">{{ $applications->links() }}</div>
@endsection
