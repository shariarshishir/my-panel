<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewRfqHasPublishedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public  $selectedUserToSendMail;
    public  $rfq;
    public function __construct($selectedUserToSendMail,$rfq)
    {
        $this->selectedUserToSendMail = $selectedUserToSendMail;
        $this->rfq = $rfq;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
