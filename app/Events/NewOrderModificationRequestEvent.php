<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewOrderModificationRequestEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $orderModificationRequest;

    public function __construct($orderModificationRequest)
    {

        $this->orderModificationRequest = $orderModificationRequest;
    }


    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
