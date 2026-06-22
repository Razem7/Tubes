@extends('layouts.app')

@section('title', 'Admin Dashboard - GadgetHub')

@section('content')
<div class="grid gap-6 lg:grid-cols-3">
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold">Total Produk</h2>
        <p class="mt-4 text-4xl font-bold text-blue-600">{{ $productCount }}</p>
    </div>
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold">Total Pengguna</h2>
        <p class="mt-4 text-4xl font-bold text-blue-600">{{ $userCount }}</p>
    </div>
    <div class="bg-white rounded-xl shadow p-6 lg:col-span-2">
        <h2 class="text-lg font-semibold">Produk Terbaru</h2>
        <div class="mt-4 space-y-3">
            @forelse($recentProducts as $product)
            <div class="border rounded-lg p-4 flex justify-between items-center">
                <div>
                    <h3 class="font-semibold">{{ $product->title }}</h3>
                    <p class="text-sm text-gray-600">Penjual: {{ $product->user->name }}</p>
                </div>
                <span class="text-sm {{ $product->is_sold ? 'text-red-600' : 'text-green-600' }}">
                    {{ $product->is_sold ? 'Terjual' : 'Tersedia' }}
                </span>
            </div>
            @empty
            <p class="text-gray-500">Belum ada produk terbaru.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
