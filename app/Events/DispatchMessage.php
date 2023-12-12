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

class DispatchMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $message;
    public $sender_id;
    public $reciever_id;
    public $profile_pic;
    public $type;
    public $deadline;
    public $task_id;
    public $name;
    public function __construct($message, $sender_id, $reciever_id, $type = "message", $deadline = null, $task_id = null)
    {
        $this->message = $message;
        $this->sender_id = $sender_id;
        $this->reciever_id = $reciever_id;
        $user = User::find($sender_id);
        $this->name = $user->name;
        $this->profile_pic = $user->profile->profile_picture;
        $this->type = $type;
        $this->deadline = $deadline;
        $this->task_id = $task_id;
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
