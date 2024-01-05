<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use App\Mail\CreateAccountMail;
use App\Jobs\CreateAccountMailJob;


class UserController extends Controller
{
    public function get() {

        
        $response = Gate::allows("allowed-user", auth()->user()->profile->role);
        if(!$response) {
            return redirect()->back();
        };

        $user = User::find(auth()->user()->id);
        $users = User::paginate(5);
        return view("users", compact("users"));
    }

    public function create() {
        
        $response = Gate::inspect("create", auth()->user());
        if(!$response->allowed()) {
            return redirect()->back();
        };
        $roles = Role::all();
        return view("create_user", compact("roles"));
    }
    public function store() {

        $response = Gate::inspect("create", auth()->user());
        if(!$response->allowed()) {
            return redirect()->back();
        };

        $role = (int)request()->get("role");
        $name = request()->get("name");
        $last_name = request()->get("last_name");
        $salary = request()->get("salary");
        $email = request()->get("email");

        // Validating the incoming inputs

        $validator = Validator::make(request()->all(), [
            "role" => "required",
            "name" => "required|min:4|max:20",
            "last_name" => "required|min:4|max:20",
            "salary" => "required|numeric",
            "email" => "required|email"
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
            "registration_code" => $code,
            "email" => $email
        ]);

        // Sending Email to the incoming employee

        dispatch(new CreateAccountMailJob($name, $code, $email));
        // $mailData = [
        //     "name" => $name,
        //     "uuid" => $code
        // ];
    
        // Mail::to($email)->send(new CreateAccountMail($mailData));
        

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
        $response = Gate::allows("allowed-user-update", auth()->user());
        if(!$response) {
            return redirect()->back();
        };
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
        $response = Gate::inspect("update", auth()->user());
        if(!$response->allowed()) {
            return redirect()->back();
        };
        $roles = Role::all();
        return view("update_user", compact("user", "roles"));
    }
    public function destroy(User $user) {
        $response = Gate::inspect("delete", auth()->user());
        if(!$response->allowed()) {
            return redirect()->back();
        };
        $user->delete();
        return 1;
    }
}
