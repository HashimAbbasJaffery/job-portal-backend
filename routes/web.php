<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;
use App\Models\User;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TaskController;

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
Route::middleware("auth")->group(function() {


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get("/chats", [ChatController::class, "index"])->name("chats");
Route::post("/sendMessage", [MessageController::class, "store"]);

// Task Routes
Route::get("/task/{user:id}/create", [TaskController::class, "create"]);
Route::post("/task/{user:id}/create", [TaskController::class, "store"]);
Route::get("/tasks", [TaskController::class, "get"])->name("tasks");
Route::get("/task/{task:id}", [TaskController::class, "getTask"]);
Route::post("/task/{task:id}/submit", [TaskController::class, "submit"]);
Route::get("/task/{task:id}/download", [TaskController::class, "download"]);

// Settings Routes
Route::get("/setting", [SettingController::class, "index"])->name("setting");
Route::post("/setting/update_password", [SettingController::class, "update_password"]);
Route::post("/setting/update_profile", [SettingController::class, "update_profile"]);
Route::post("/setting/upload_profile_pic", [SettingController::class, "upload_pic"]);


// Notifications Routes 
Route::get("/notifications", [NotificationController::class, "get"])->name("notifications");
Route::delete("/notification/{id}/delete", [NotificationController::class, "destroy"]);


// Role Routes 

Route::get("/roles", [RoleController::class, "index"])->name("roles");
Route::get("/role/create", [RoleController::class, "create"]);
Route::post("/role/create", [RoleController::class, "store"]);
Route::get("/role/{role:id}/update", [RoleController::class, "update"]);
Route::post("/role/{role:id}/update", [RoleController::class, "edit"]);
Route::delete("/role/{role:id}/delete", [RoleController::class, "destroy"]);


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

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
