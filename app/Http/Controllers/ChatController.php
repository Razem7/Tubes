<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use App\Models\Product;
use App\Notifications\NewMessageNotification;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $chats = Chat::where('buyer_id', auth()->id())
            ->orWhere('seller_id', auth()->id())
            ->with(['product.photos', 'buyer', 'seller', 'latestMessage'])
            ->latest('updated_at')
            ->get();

        return view('chats.index', compact('chats'));
    }

    public function show(Chat $chat)
    {
        // Ensure user is part of this chat
        if ($chat->buyer_id !== auth()->id() && $chat->seller_id !== auth()->id()) {
            abort(403);
        }

        $chat->load(['product.photos', 'buyer', 'seller', 'messages.sender']);

        // Mark messages as read
        $chat->messages()
            ->where('sender_id', '!=', auth()->id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        // Mark related chat notifications as read so the dot disappears
        auth()->user()
            ->unreadNotifications()
            ->where('data->chat_id', $chat->id)
            ->update(['read_at' => now()]);

        return view('chats.show', compact('chat'));
    }

    public function startChat(Product $product)
    {
        // Cannot chat with yourself
        if ($product->user_id === auth()->id()) {
            return back()->with('error', 'Anda tidak bisa chat dengan diri sendiri!');
        }

        // Find or create chat
        $chat = Chat::firstOrCreate([
            'product_id' => $product->id,
            'buyer_id' => auth()->id(),
            'seller_id' => $product->user_id,
        ]);

        return redirect()->route('chats.show', $chat);
    }

    public function sendMessage(Request $request, Chat $chat)
    {
        // Ensure user is part of this chat
        if ($chat->buyer_id !== auth()->id() && $chat->seller_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $message = Message::create([
            'chat_id' => $chat->id,
            'sender_id' => auth()->id(),
            'message_text' => $validated['message'],
        ]);

        $chat->touch(); // Update chat's updated_at timestamp

        // Kirim notifikasi ke penerima (lawan bicara)
        $recipientId = $chat->buyer_id === auth()->id() ? $chat->seller_id : $chat->buyer_id;
        $recipient = \App\Models\User::find($recipientId);
        if ($recipient) {
            $message->load('sender', 'chat');
            $recipient->notify(new NewMessageNotification($message));
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message->load('sender'),
            ]);
        }

        return back();
    }
}
