<?php

namespace App\View\Components;

use App\Models\Notification;
use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        $notifications = Notification::where("user_id", auth()->user()->id)
            ->where("isRead", 0)
            ->first();
        $messages = "";
        $unread_notification = "";
        $notification_count = "";
        if($notifications) {
            $messages = json_decode($notifications->message);
            $unread_notification = array_filter($messages, function($message) {
                return $message->isRead === false;
            });
            $notification_count = count($unread_notification);
        }
        return view('layouts.app', compact("notification_count"));
    }
}
