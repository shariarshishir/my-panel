<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewUserHasRegisteredEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public  $user;
    public  $token;
    public function __construct($user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
