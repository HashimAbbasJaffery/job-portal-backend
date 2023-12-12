<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\User;

class NotificationController extends Controller
{
    public function getMessage($messages, $type = "unread") {
        return array_filter($messages, function($message) use($type) {
            if($type === "unread") {
                return $message->isRead = false;
            } else {
                return $message->isRead = true;
            }
        });
    }
    public function destroy($id) {
        $notifications = Notification::where("user_id", auth()->user()->id)->first();
        $messages = json_decode($notifications->message);
        $updated_messages = array_filter($messages, function($message) use($id) {
            return $message->id !== $id;
        });;
        $notifications->update([
            "message" => json_encode(array_values($updated_messages))
        ]);
        return 1;
    }
    public function get() {
        $loggedInUser = auth()->user()->id;

        // Getting all notifications of the logged in user
        $notifications = Notification::where("user_id", $loggedInUser)->first();

        // decoding the json message to the readable php associative arrays
        $messages = json_decode($notifications->message);
        // Filtering the array which are not read
        $unread_messages = $this->getMessage($messages);

        
        // Converting the unread message to the messages which are read by the user
        foreach($unread_messages as $unread_message) {
            $unread_message->isRead = true;
        }
        $notifications->update([
            "isRead" => 1
        ]);
        return view("notification", compact("messages"));

    }
    public function sendNotification(User $user) {

    }
}
