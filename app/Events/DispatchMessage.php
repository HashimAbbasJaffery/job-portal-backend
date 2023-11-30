<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DispatchMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $message;
    public $sender_id;
    public $reciever_id;
    public function __construct($message, $sender_id, $reciever_id)
    {
        $this->message = $message;
        $this->sender_id = $sender_id;
        $this->reciever_id = $reciever_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        $communication_between = [ $this->sender_id, $this->reciever_id ];
        $ids = sort($communication_between);
        $channel_name = implode(".", $communication_between) . ".channel";
        return [ $channel_name ]; 
    }
    public function broadcastAs() {
        return "dispatch-message";
    }
}
