<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $message;
    public string $username;
    public array $members;

    /**
     * @param string $message
     */
    public function __construct(string $message, string $username, array $members)
    {
        $this->message = $message;
        $this->username = $username;
        $this->members = $members;
    }

    /**
     * @return string[]
     */
    public function broadcastOn(): array
    {
        return ['chat-app'];
    }

    /**
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'chat';
    }
}
