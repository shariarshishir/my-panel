<?php



namespace App\Events;



use Illuminate\Broadcasting\Channel;

use Illuminate\Queue\SerializesModels;

use Illuminate\Broadcasting\PrivateChannel;

use Illuminate\Broadcasting\PresenceChannel;

use Illuminate\Foundation\Events\Dispatchable;

use Illuminate\Broadcasting\InteractsWithSockets;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;



class MessageCenter implements ShouldBroadcast

{

    use Dispatchable, InteractsWithSockets, SerializesModels;



    /**

     * Create a new event instance.

     *

     * @return void

     */

    public $user_id;

    public $message;



    public function __construct($user_id, $message)

    {

        $this->user_id=$user_id;

        $this->message=$message;

    }



    /**

     * Get the channels the event should broadcast on.

     *

     * @return \Illuminate\Broadcasting\Channel|array

     */

    public function broadcastOn()
    {

        return new PrivateChannel('message-center.'.$this->user_id);

    }

}

