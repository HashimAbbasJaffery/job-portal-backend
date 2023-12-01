<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Contact;
use App\Models\Message;

class ChatController extends Controller
{
    public function index() {
        $loggedInUser = auth()->user()->id;

        
        $rawContacts = Contact::where("user_id_1", $loggedInUser)
                            ->orWhere("user_id_2", $loggedInUser)
                            ->get();

        $contacts = [];
        foreach($rawContacts as $rawContact) {
            $messages = Message::where("message_id", $rawContact->message_id)->first();
            if($rawContact->user_id_1 === $loggedInUser) {
                $user = User::find($rawContact->user_id_2);
                $messageArr = json_decode($messages?->messages);
                if($messageArr) {
                    $user["lastMessage"] = $messageArr[count($messageArr) - 1];
                } else {
                    $user["lastMessage"] = "No message found!";
                }
                $user["message_id"] = $rawContact->message_id;
                array_push($contacts, $user);
            } else {
                $user = User::find($rawContact->user_id_1);
                $messageArr = json_decode($messages?->messages);
                if($messageArr) {
                    $user["lastMessage"] = $messageArr[count($messageArr) - 1];
                } else {
                    $user["lastMessage"] = "No message found!";
                }
                $user["message_id"] = $rawContact->message_id;
                array_push($contacts, $user);
            }
        }        
        return view("chat", compact("contacts"));
    }
}
