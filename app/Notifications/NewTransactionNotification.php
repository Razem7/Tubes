<?php

namespace App\Notifications;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewTransactionNotification extends Notification
{
    use Queueable;

    public function __construct(public Transaction $transaction) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $product = $this->transaction->product;
        $buyer   = $this->transaction->buyer;

        return [
            'type'           => 'new_transaction',
            'message'        => $buyer->name . ' membeli produk Anda: ' . $product->name,
            'product_name'   => $product->name,
            'buyer_name'     => $buyer->name,
            'amount'         => $this->transaction->amount,
            'transaction_id' => $this->transaction->id,
            'url'            => route('transactions.show', $this->transaction->id),
        ];
    }
}
