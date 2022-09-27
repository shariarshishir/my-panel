<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewAnonymousUserHasRegisteredEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public  $user;
    public  $token;
    public  $password;
    public function __construct($user, $token, $password)
    {
        $this->user = $user;
        $this->token = $token;
        $this->password = $password;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
