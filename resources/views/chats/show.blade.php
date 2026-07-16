@extends('layouts.app')

@section('title', 'GadgetHub - Chat')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <!-- Chat Header -->
        <div class="border-b p-4">
            <div class="flex items-center space-x-4">
                <img src="{{ $chat->product->photos->first() && $chat->product->photos->first()->photo_url ? asset($chat->product->photos->first()->photo_url) : 'https://via.placeholder.com/80' }}" 
                     alt="{{ $chat->product->title }}"
                     class="w-16 h-16 object-cover rounded">
                <div class="flex-1">
                    <h3 class="font-semibold">{{ $chat->product->title }}</h3>
                    <p class="text-sm text-gray-600">
                        Chat dengan {{ $chat->buyer_id === auth()->id() ? $chat->seller->name : $chat->buyer->name }}
                    </p>
                    <p class="text-sm font-semibold text-blue-600">Rp {{ number_format($chat->product->price, 0, ',', '.') }}</p>
                </div>
                <a href="{{ route('products.show', $chat->product) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Lihat Produk
                </a>
            </div>
        </div>

        <!-- Messages -->
        <div class="p-4 h-96 overflow-y-auto" id="messagesContainer">
            @forelse($chat->messages as $message)
            <div class="mb-4 {{ $message->sender_id === auth()->id() ? 'text-right' : '' }}">
                <div class="inline-block max-w-xs lg:max-w-md">
                    @if($message->sender_id !== auth()->id())
                    <p class="text-xs text-gray-500 mb-1">{{ $message->sender->name }}</p>
                    @endif
                    <div class="rounded-lg px-4 py-2 {{ $message->sender_id === auth()->id() ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-900' }}">
                        <p>{{ $message->message_text }}</p>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">
                        {{ $message->created_at->format('H:i') }}
                    </p>
                </div>
            </div>
            @empty
            <p class="text-center text-gray-500">Belum ada pesan. Mulai percakapan!</p>
            @endforelse
        </div>

        <!-- Message Input -->
        <div class="border-t p-4">
            <form action="{{ route('chats.send', $chat) }}" method="POST" class="flex gap-2">
                @csrf
                <input type="text" 
                       name="message" 
                       placeholder="Tulis pesan..."
                       class="flex-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required
                       maxlength="1000">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    Kirim
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Auto scroll to bottom
document.addEventListener('DOMContentLoaded', function() {
    var container = document.getElementById('messagesContainer');
    container.scrollTop = container.scrollHeight;
});
</script>
@endpush
@endsection
