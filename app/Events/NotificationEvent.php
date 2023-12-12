<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class NotificationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $reciever_id;
    public $sender_id;
    public $sender_name;
    public $message;
    public $type;
    public function __construct($sender_id = null, $reciever_id, $message, $type = "message")
    {
        $this->reciever_id = $reciever_id;
        $this->message = $message;
        if($sender_id) {
            $user = User::select("name")->find($sender_id);
            $this->sender_name = $user->name;
        }
        $this->sender_id = $sender_id;
        $this->type = $type;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [ "notification." . $this->reciever_id ];
    }
    public function broadcastAs() {
        return "notification-event";
    }
}
