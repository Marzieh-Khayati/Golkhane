<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMessage
{
   use Dispatchable, InteractsWithSockets;

    public function __construct(
        public int $sessionId,
        public string $message,
        public int $senderId,
        public string $createdAt
    ) {}

    public function broadcastOn(): Channel
    {
        return new Channel("chat.{$this->sessionId}");
    }
}
