<?php

namespace App\Notifications;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TransactionStatusNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Transaction $transaction,
        public string $newStatus
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $product = $this->transaction->product;

        $messages = [
            'confirmed' => 'Pesanan kamu untuk ' . $product->title . ' telah dikonfirmasi oleh penjual.',
            'rejected'  => 'Pesanan kamu untuk ' . $product->title . ' ditolak oleh penjual.',
            'completed' => 'Pembeli telah mengkonfirmasi penerimaan ' . $product->title . '. Transaksi selesai!',
        ];

        $types = [
            'confirmed' => 'transaction_confirmed',
            'rejected'  => 'transaction_rejected',
            'completed' => 'transaction_completed',
        ];

        return [
            'type'           => $types[$this->newStatus] ?? 'transaction_update',
            'message'        => $messages[$this->newStatus] ?? 'Status transaksi diperbarui.',
            'transaction_id' => $this->transaction->id,
            'url'            => route('transactions.show', $this->transaction->id),
        ];
    }
}
