<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Jumlah chat dengan pesan belum dibaca (untuk polling JS)
    public function unreadChats()
    {
        $count = \App\Models\Chat::where(function ($q) {
                $q->where('buyer_id', auth()->id())
                  ->orWhere('seller_id', auth()->id());
            })
            ->whereHas('messages', function ($q) {
                $q->where('sender_id', '!=', auth()->id())
                  ->whereNull('read_at');
            })
            ->count();

        return response()->json(['count' => $count]);
    }

    // Ambil notifikasi unread (untuk polling)
    public function index()
    {
        $userId = auth()->id();

        // Ambil semua unread notifikasi
        $raw = auth()->user()->unreadNotifications()->latest()->take(50)->get();

        // Untuk notifikasi new_message: skip jika chat-nya sudah tidak punya pesan unread
        // (artinya user sudah buka chat tsb, messages sudah di-read, tapi notifnya belum di-mark)
        $readChatIds = \App\Models\Chat::where(function ($q) use ($userId) {
                $q->where('buyer_id', $userId)->orWhere('seller_id', $userId);
            })
            ->whereDoesntHave('messages', function ($q) use ($userId) {
                $q->where('sender_id', '!=', $userId)->whereNull('read_at');
            })
            ->pluck('id')
            ->toArray();

        // Auto mark-read notif new_message yang chat-nya sudah dibaca
        $toMarkRead = $raw->filter(function ($n) use ($readChatIds) {
            if (($n->data['type'] ?? '') === 'new_message') {
                $chatId = $n->data['chat_id'] ?? null;
                return $chatId && in_array($chatId, $readChatIds);
            }
            return false;
        });

        if ($toMarkRead->isNotEmpty()) {
            $toMarkRead->each->markAsRead();
        }

        // Ambil ulang setelah auto-mark
        $notifications = auth()->user()
            ->unreadNotifications()
            ->latest()
            ->take(15)
            ->get()
            ->map(fn($n) => [
                'id'         => $n->id,
                'type'       => $n->data['type'] ?? 'info',
                'message'    => $n->data['message'] ?? '',
                'url'        => $n->data['url'] ?? '#',
                'created_at' => $n->created_at->diffForHumans(),
            ]);

        return response()->json([
            'count'         => $notifications->count(),
            'notifications' => $notifications,
        ]);
    }

    // Tandai satu notifikasi sebagai sudah dibaca
    public function markAsRead(Request $request, string $id)
    {
        $notification = auth()->user()
            ->unreadNotifications()
            ->where('id', $id)
            ->first();

        if ($notification) {
            $notification->markAsRead();
        }

        return response()->json(['success' => true]);
    }

    // Tandai semua notifikasi sebagai sudah dibaca
    public function markAllRead()
    {
        auth()->user()->unreadNotifications()->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }
}
