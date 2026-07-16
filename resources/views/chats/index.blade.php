@extends('layouts.app')

@section('title', 'GadgetHub - Chat')

@section('content')
<div class="max-w-4xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Chat Saya</h2>
    
    @if($chats->count() > 0)
    <div class="bg-white rounded-lg shadow divide-y">
        @foreach($chats as $chat)
        @php
            $otherUser = $chat->buyer_id === auth()->id() ? $chat->seller : $chat->buyer;
            $unreadCount = $chat->unreadMessagesCount(auth()->id());
        @endphp
        <a href="{{ route('chats.show', $chat) }}" class="block p-4 hover:bg-gray-50 transition">
            <div class="flex items-start space-x-4">
                <img src="{{ $chat->product->photos->first() && $chat->product->photos->first()->photo_url ? asset($chat->product->photos->first()->photo_url) : 'https://via.placeholder.com/80' }}" 
                     alt="{{ $chat->product->title }}"
                     class="w-16 h-16 object-cover rounded">
                <div class="flex-1 min-w-0">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-semibold text-gray-900 truncate">{{ $chat->product->title }}</h3>
                            <p class="text-sm text-gray-600">{{ $otherUser->name }}</p>
                        </div>
                        @if($unreadCount > 0)
                        <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded-full">{{ $unreadCount }}</span>
                        @endif
                    </div>
                    @if($chat->latestMessage)
                    <p class="text-sm text-gray-500 mt-1 truncate">
                        {{ $chat->latestMessage->message_text }}
                    </p>
                    <p class="text-xs text-gray-400 mt-1">
                        {{ $chat->latestMessage->created_at->diffForHumans() }}
                    </p>
                    @endif
                </div>
            </div>
        </a>
        @endforeach
    </div>
    @else
    <div class="bg-white rounded-lg shadow p-8 text-center">
        <p class="text-gray-600">Belum ada chat.</p>
        <a href="{{ route('products.index') }}" class="text-blue-600 hover:underline mt-2 inline-block">
            Jelajah Produk
        </a>
    </div>
    @endif
</div>
@endsection
