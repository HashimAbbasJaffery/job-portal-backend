<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;
use App\Models\User;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get("/chats", [ChatController::class, "index"])->name("chats");
Route::get("/notifications", [NotificationController::class, "get"])->name("notifications");
Route::post("/sendMessage", [MessageController::class, "store"]);


// Users Route;
Route::get("/users", [UserController::class, "get"])->name("users");
Route::get("/users/create", [UserController::class, "create"]);
Route::post("/users/create", [UserController::class, "store"]);
Route::get("/user/{user:id}/update", [UserController::class, "update"]);
Route::post("/user/{user:id}/edit", [UserController::class, "edit"]);
Route::delete("/user/{user:id}/delete", [UserController::class, "destroy"]);

Route::get("/createUser", function() {
    User::create([
        "name" => "hashim abbas",
        "last_name" => "jaffery",
        "address" => "shidfhsd",
        "email" => "habbas21219@gmail.com",
        "password" => Hash::make("12345"),
        "profile_id" => 1
    ]);
});

Route::get("/get/message/{key}", [MessageController::class, "get"]);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
