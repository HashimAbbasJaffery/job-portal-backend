<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Events\UserOnline;

class UserOnlineController extends Controller
{
    public function __invoke(User $user) {
        $user->status = 'online';
        $user->save();
    }
}
