<?php

use App\Http\Controllers\MessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserOnlineController;
use App\Models\User;
use App\Models\Role;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::middleware('auth:api')->put('user/{user}/online', UserOnlineController::class);

Route::get("/users/get", function() {
    $keyword = request()->get("keyword");
    if(!$keyword) {
        $keyword = "";
    }
    $users = User::where("name", "like", "%" . $keyword . "%")->paginate(5);
    if($keyword) {
        $users->appends([ "keyword" => $keyword ]);
    }
    return $users;
});

Route::get("/roles/get", function() {
    $keyword = request()->get("keyword");
    if(!$keyword) {
        $keyword = "";
    }
    $roles = Role::where("name", "like", "%" . $keyword . "%")->paginate(5);
    if($keyword) {
        $roles->appends([ "keyword" => $keyword ]);
    }
    return $roles;
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
