<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
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


        // creating user and attaching that to the specific profile
        User::create([
            "name" => $name,
            "last_name" => $last_name,
            "address" => "",
            "profile_id" => $profile->id,
            "password" => ""
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
        $user->update([
            "name" => $name,
            "last_name" => $last_name,
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
