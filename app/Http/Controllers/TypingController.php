<?php

namespace App\Http\Controllers;

use App\Events\TypingEvent;
use Illuminate\Http\Request;

class TypingController extends Controller
{
    public function typing($reciever_id) {
        $typer_id = auth()->user()->id;

        event(new TypingEvent($typer_id, $reciever_id));
    }
}
