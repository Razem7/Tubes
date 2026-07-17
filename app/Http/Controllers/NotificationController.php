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

    // Jumlah transaksi yang butuh aksi dari user ini (untuk polling dot)
    public function unreadTransactions()
    {
        $userId = auth()->id();

        // Seller: transaksi pending yang belum dikonfirmasi
        $pendingSeller = \App\Models\Transaction::where('seller_id', $userId)
            ->where('status', \App\Models\Transaction::STATUS_PENDING)
            ->count();

        // Buyer: transaksi confirmed yang menunggu konfirmasi penerimaan dari buyer
        $waitingBuyer = \App\Models\Transaction::where('buyer_id', $userId)
            ->where('status', \App\Models\Transaction::STATUS_CONFIRMED)
            ->count();

        return response()->json(['count' => $pendingSeller + $waitingBuyer]);
    }

    // Ambil notifikasi unread (untuk polling)
    public function index()
    {
        $userId = auth()->id();

        $raw = auth()->user()->unreadNotifications()->latest()->take(50)->get();
        $toMarkRead = collect();

        // ── 1. new_message: mark-read jika chat sudah tidak punya pesan unread ──
        $readChatIds = \App\Models\Chat::where(function ($q) use ($userId) {
                $q->where('buyer_id', $userId)->orWhere('seller_id', $userId);
            })
            ->whereDoesntHave('messages', function ($q) use ($userId) {
                $q->where('sender_id', '!=', $userId)->whereNull('read_at');
            })
            ->pluck('id')
            ->toArray();

        // ── 2. Notif transaksi: mark-read jika transaksi sudah tidak butuh aksi ──
        // Transaksi yang masih butuh aksi:
        // - Seller: pending (belum konfirmasi)
        // - Buyer: confirmed (belum konfirmasi terima)
        $actionNeededTrxIds = \App\Models\Transaction::where(function ($q) use ($userId) {
                // Seller menunggu konfirmasi
                $q->where('seller_id', $userId)->where('status', \App\Models\Transaction::STATUS_PENDING);
            })
            ->orWhere(function ($q) use ($userId) {
                // Buyer menunggu konfirmasi terima
                $q->where('buyer_id', $userId)->where('status', \App\Models\Transaction::STATUS_CONFIRMED);
            })
            ->pluck('id')
            ->toArray();

        foreach ($raw as $n) {
            $type = $n->data['type'] ?? '';

            if ($type === 'new_message') {
                $chatId = $n->data['chat_id'] ?? null;
                if ($chatId && in_array($chatId, $readChatIds)) {
                    $toMarkRead->push($n);
                }
            } elseif (in_array($type, [
                'new_transaction',
                'transaction_confirmed',
                'transaction_rejected',
                'transaction_completed',
            ])) {
                $trxId = $n->data['transaction_id'] ?? null;
                // Mark-read jika transaksi ini tidak butuh aksi lagi
                if ($trxId && ! in_array($trxId, $actionNeededTrxIds)) {
                    $toMarkRead->push($n);
                }
            } else {
                // Tipe tidak dikenal — langsung mark-read agar tidak timbul ghost dot
                $toMarkRead->push($n);
            }
        }

        if ($toMarkRead->isNotEmpty()) {
            $toMarkRead->unique('id')->each->markAsRead();
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
