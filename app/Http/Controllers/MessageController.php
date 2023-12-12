<?php

namespace App\Http\Controllers;

use App\Events\DispatchMessage;
use App\Events\NotificationEvent;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function get($key) {
        $messages = Message::where("message_id", $key)->first();
        return [$messages, Auth::user()->id];
    }
    protected function storeMessageNotification($sender_id, $reciever_id, $message) {
        $notification = Notification::where("user_id", $reciever_id)->first();
        if(!$notification) {
            $notification = Notification::create([
                "user_id" => $reciever_id,
                "message" => "[]",
                "isRead" => true
            ]);
        }

        // Updating the current notification associated to specific user

        $notifications = json_decode($notification->message);
        $notifications = [
            ...$notifications,
            [
                "id" => (string)str()->uuid(),
                "message" => $message,
                "isRead" => false,
                "type" => "message"
            ]
        ];
        if($sender_id) {
            $user = User::select("name")->find($sender_id);
            $notifications[count($notifications) - 1]["sender_name"] = $user->name;
        }
        $notification->update([
            "message" => json_encode($notifications),
            "isRead" => false
        ]);
    }

    public function store() {
        $sender_id = (int)request()->get("sender_id");
        $reciever_id = (int)request()->get("reciever_id");
        $message = request()->get("message");
        $key = request()->get("key");
        
        event(new DispatchMessage($message, $sender_id, $reciever_id));
        event(new NotificationEvent($sender_id, $reciever_id, $message));
        $this->storeMessageNotification($sender_id, $reciever_id, $message);

        $sender = User::find($sender_id);
        
        $messageInstance = Message::where("message_id", $key)->first();
        $messages = json_decode($messageInstance->messages);
        $updatedMessages = [
            ...$messages,
            [
                "profile_pic" => $sender->profile->profile_picture,
                "sender" => $sender_id,
                "message" => $message,
                "name" => $sender->name,
                "type" => "message"
            ]
        ];
        $messageInstance->update(
            [
                "messages" => json_encode($updatedMessages)
            ]
        );
    }
}
