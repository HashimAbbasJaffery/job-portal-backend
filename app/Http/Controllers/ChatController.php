<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function index() {
        $loggedInUser = auth()->user()->id;

        
        $rawContacts = DB::table("contact_relationship")
                ->where("user_id_1", $loggedInUser)
                ->orWhere("user_id_2", $loggedInUser)
                ->get();
        $contacts = [];
        foreach($rawContacts as $rawContact) {
            if($rawContact->user_id_1 === $loggedInUser) {
                $user = User::find($rawContact->user_id_2);
                $user["message_id"] = $rawContact->message_id;
                array_push($contacts, $user);
            } else {
                $user = User::find($rawContact->user_id_1);
                $user["message_id"] = $rawContact->message_id;
                array_push($contacts, $user);
            }
        }        
        return view("chat", compact("contacts"));
    }
}
