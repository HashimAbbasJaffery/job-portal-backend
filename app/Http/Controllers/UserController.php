<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function get() {
        $users = User::paginate(5);
        return view("users", compact("users"));
    }

    public function create() {
        $roles = Role::all();
        return view("create_user", compact("roles"));
    }
    public function store() {
        $role = (int)request()->get("role");
        $name = request()->get("name");
        $last_name = request()->get("last_name");
        $salary = request()->get("salary");

        // Validating the incoming inputs

        $validator = Validator::make(request()->all(), [
            "role" => "required",
            "name" => "required|min:4|max:20",
            "last_name" => "required|min:4|max:20",
            "salary" => "required|numeric"
        ]);

        // If Validating fails 

        if($validator->fails()) {
            return response()->json(["errors" => $validator->errors()]);
        }

        // Creating associated profile for the user
        $profile = Profile::create([
            "tasks_assigned" => 0,
            "salary" => $salary,
            "role_id" => $role
        ]);

        $code = (string)str()->uuid();
        // creating user and attaching that to the specific profile
        $user = User::create([
            "name" => $name,
            "last_name" => $last_name,
            "address" => "",
            "profile_id" => $profile->id,
            "password" => "",
            "registration_code" => $code
        ]);

        // Making the chats between user being created and the one who is creating it
        $message_id = (string)str()->uuid();
        $relationship = DB::table("contact_relationship")->insert([
            "user_id_1" => $user->id,
            "user_id_2" => auth()->user()->id,
            "message_id" => $message_id
        ]);

        // Establishing the chat between two users

        $chats = DB::table("chat_messages")->insert([
            "message_id" => $message_id,
            "messages" => "[]"
        ]);

        return 1;
    }
    public function edit(User $user) {
        $role = (int)request()->get("role");
        $name = request()->get("name");
        $last_name = request()->get("last_name");
        $salary = request()->get("salary");

        // Validating the incoming inputs

        $validator = Validator::make(request()->all(), [
            "role" => "required",
            "name" => "required|min:4|max:20",
            "last_name" => "required|min:4|max:20",
            "salary" => "required|numeric"
        ]);

        // If Validating fails 

        if($validator->fails()) {
            return response()->json(["errors" => $validator->errors()]);
        }

        // Updating the profile of the user
        $profile = Profile::find($user->profile_id);
        $profile = $profile->update([
            "salary" => $salary,
            "role_id" => $role
        ]);


        // creating user and attaching that to the specific profile
        $uuid = (string)str()->uuid();
        $user->update([
            "name" => $name,
            "last_name" => $last_name,
            "registration_code" => $uuid
        ]);

        return 1;
    }
    public function update(User $user) {
        $roles = Role::all();
        return view("update_user", compact("user", "roles"));
    }
    public function destroy(User $user) {
        $user->delete();
        return 1;
    }
}
