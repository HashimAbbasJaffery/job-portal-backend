<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Events\UserOffline;

class UserOfflineController extends Controller
{
    public function __invoke(User $user) {
        $user->status = 'offline';
        $user->save();
    }
}
