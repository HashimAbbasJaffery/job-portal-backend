<?php

namespace App\Http\Controllers;

use App\Events\DispatchMessage;
use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function get($key) {
        $messages = Message::where("message_id", $key)->first();
        return [$messages, Auth::user()->id];
    }

    public function store() {
        $sender_id = (int)request()->get("sender_id");
        $reciever_id = (int)request()->get("reciever_id");
        $message = request()->get("message");
        event(new DispatchMessage($message, $sender_id, $reciever_id));
    }
}
