<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function get() {
        $loggedInUser = auth()->user()->id;
        $notifications = Notification::where("user_id", $loggedInUser)->first();
        $notificationMessages = json_decode($notifications->message);
        $unread_messages = array_filter(json_decode($notifications->message), function($message) {
            return $message->isRead === false;
        });
        $readNotifications = array_map(function($notification) {
            $notification->isRead = true;
            return $notification;
        }, $unread_messages);
        $updatedNotifications = [];
        $notifications->update([
            "message" => $updatedNotifications,
            "isRead" => true  
        ]);
        return view("notification", compact("unread_messages"));

    }
}
