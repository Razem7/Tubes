@extends('layouts.admin')

@section('title', 'Admin Dashboard - GadgetHub')

@section('content')
<div class="mb-6">
    <h2 class="text-3xl font-bold">Dashboard Admin</h2>
    <p class="text-gray-600">Selamat datang, {{ auth()->user()->name }}</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-1">
                <p class="text-gray-600 text-sm">Total Users</p>
                <p class="text-3xl font-bold text-blue-600">{{ $stats['total_users'] }}</p>
            </div>
            <svg class="w-12 h-12 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
            </svg>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-1">
                <p class="text-gray-600 text-sm">Total Produk</p>
                <p class="text-3xl font-bold text-green-600">{{ $stats['total_products'] }}</p>
            </div>
            <svg class="w-12 h-12 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"></path>
            </svg>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-1">
                <p class="text-gray-600 text-sm">Produk Terjual</p>
                <p class="text-3xl font-bold text-yellow-600">{{ $stats['total_sold'] }}</p>
            </div>
            <svg class="w-12 h-12 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-1">
                <p class="text-gray-600 text-sm">Total Chat</p>
                <p class="text-3xl font-bold text-purple-600">{{ $stats['total_chats'] }}</p>
            </div>
            <svg class="w-12 h-12 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"></path>
            </svg>
        </div>
    </div>
</div>

<!-- Recent Products -->
<div class="bg-white rounded-lg shadow mb-6">
    <div class="p-6 border-b">
        <h3 class="text-xl font-semibold">Produk Terbaru</h3>
    </div>
    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b">
                        <th class="text-left py-2">Foto</th>
                        <th class="text-left py-2">Judul</th>
                        <th class="text-left py-2">Harga</th>
                        <th class="text-left py-2">Penjual</th>
                        <th class="text-left py-2">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recent_products as $product)
                    <tr class="border-b">
                        <td class="py-2">
                            <img src="{{ $product->photos->first() && $product->photos->first()->photo_url ? asset($product->photos->first()->photo_url) : 'https://via.placeholder.com/50' }}" 
                                 alt="{{ $product->title }}"
                                 class="w-12 h-12 object-cover rounded">
                        </td>
                        <td class="py-2">{{ $product->title }}</td>
                        <td class="py-2">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="py-2">{{ $product->user->name }}</td>
                        <td class="py-2">{{ $product->created_at->format('d/m/Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Recent Users -->
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b">
        <h3 class="text-xl font-semibold">User Terbaru</h3>
    </div>
    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b">
                        <th class="text-left py-2">Nama</th>
                        <th class="text-left py-2">Email</th>
                        <th class="text-left py-2">No HP</th>
                        <th class="text-left py-2">Bergabung</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recent_users as $user)
                    <tr class="border-b">
                        <td class="py-2">{{ $user->name }}</td>
                        <td class="py-2">{{ $user->email }}</td>
                        <td class="py-2">{{ $user->phone_number ?? '-' }}</td>
                        <td class="py-2">{{ $user->created_at->format('d/m/Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
