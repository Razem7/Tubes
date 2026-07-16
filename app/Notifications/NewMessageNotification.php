<?php

namespace App\Notifications;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewMessageNotification extends Notification
{
    use Queueable;

    public function __construct(public Message $message) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $sender = $this->message->sender;
        $chat   = $this->message->chat;

        return [
            'type'       => 'new_message',
            'message'    => 'Pesan baru dari ' . $sender->name,
            'preview'    => \Str::limit($this->message->message_text, 60),
            'sender'     => $sender->name,
            'chat_id'    => $chat->id,
            'url'        => route('chats.show', $chat->id),
        ];
    }
}
