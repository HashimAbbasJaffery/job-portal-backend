<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

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

        
        $profile = Profile::create([
            "tasks_assigned" => 0,
            "salary" => $salary,
            "role_id" => $role
        ]);

        User::create([
            "name" => $name,
            "last_name" => $last_name,
            "address" => "",
            "email" => "",
            "profile_id" => $profile->id,
            "password" => ""
        ]);

        return 1;
    }
}
