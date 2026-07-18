<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Transaction;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function unreadChats()
    {
        $count = Chat::where(function ($q) {
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

    public function unreadTransactions()
    {
        $userId = auth()->id();

        $pendingSeller = Transaction::where('seller_id', $userId)
            ->where('status', Transaction::STATUS_PENDING)
            ->count();

        $waitingBuyer = Transaction::where('buyer_id', $userId)
            ->where('status', Transaction::STATUS_CONFIRMED)
            ->count();

        return response()->json(['count' => $pendingSeller + $waitingBuyer]);
    }

    public function index()
    {
        $userId = auth()->id();

        $raw = auth()->user()->unreadNotifications()->latest()->take(50)->get();
        $toMarkRead = collect();

        $readChatIds = Chat::where(function ($q) use ($userId) {
            $q->where('buyer_id', $userId)->orWhere('seller_id', $userId);
        })
            ->whereDoesntHave('messages', function ($q) use ($userId) {
                $q->where('sender_id', '!=', $userId)->whereNull('read_at');
            })
            ->pluck('id')
            ->toArray();

        $actionNeededTrxIds = Transaction::where(function ($q) use ($userId) {
            $q->where('seller_id', $userId)->where('status', Transaction::STATUS_PENDING);
        })
            ->orWhere(function ($q) use ($userId) {
                $q->where('buyer_id', $userId)->where('status', Transaction::STATUS_CONFIRMED);
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
                if ($trxId && ! in_array($trxId, $actionNeededTrxIds)) {
                    $toMarkRead->push($n);
                }
            } else {
                $toMarkRead->push($n);
            }
        }

        if ($toMarkRead->isNotEmpty()) {
            $toMarkRead->unique('id')->each->markAsRead();
        }

        $notifications = auth()->user()
            ->unreadNotifications()
            ->latest()
            ->take(15)
            ->get()
            ->map(fn ($n) => [
                'id' => $n->id,
                'type' => $n->data['type'] ?? 'info',
                'message' => $n->data['message'] ?? '',
                'url' => $n->data['url'] ?? '#',
                'created_at' => $n->created_at->diffForHumans(),
            ]);

        return response()->json([
            'count' => $notifications->count(),
            'notifications' => $notifications,
        ]);
    }

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

    public function markAllRead()
    {
        auth()->user()->unreadNotifications()->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }
}
