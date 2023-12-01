<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function get() {
        $loggedInUser = auth()->user()->id;
        $notifications = Notification::where("user_id", $loggedInUser)->first();

        $unread_messages = array_filter(json_decode($notifications->message), function($message) {
            return $message->isRead === false;
        });
        return view("notification", compact("unread_messages"));

    }
}
