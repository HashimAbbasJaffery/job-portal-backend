<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;


class RoleController extends Controller
{
   
    public function index() {
        $response = (bool)Gate::allows("allowed-role", auth()->user());
        if(!$response) {
            return redirect()->back();
        };
        $roles = Role::paginate(5);
        return view("roles", compact("roles"));
    }
    public function create() {
        
        $response = Gate::allows("allowed-role-create", auth()->user());
        // $response = Gate::inspect("create", auth()->user());
        if(!$response) {
            return redirect()->back();
        };
        return view("create_role");
    }
    public function store() {
        $response = Gate::allows("allowed-role-create", auth()->user());
        if(!$response) {
            return redirect()->back();
        };

        $name = request()->get("name");
        $create_user = request()->get("create_user") === "on" ? 0 : 1;
        $edit_user = request()->get("edit_user") === "on" ? 0 : 1;
        $view_users = request()->get("view_users") === "on" ? 0 : 1;
        $notify_user = request()->get("delete_user") === "on" ? 0 : 1;

        
        $create_role = request()->get("create_role") === "on" ? 0 : 1;
        $edit_role = request()->get("edit_role") === "on" ? 0 : 1;
        $view_roles = request()->get("view_roles") === "on" ? 0 : 1;
        $delete_role = request()->get("delete_role") === "on" ? 0 : 1;

        $validator = Validator::make(request()->all(), [
            "name" => "required",
        ]);

        // If Validating fails 

        if($validator->fails()) {
            return response()->json(["errors" => $validator->errors()]);
        }

        $roles = DB::table("roles")->insert([
            "name" => $name,
            "badge_color" => "#000000",
            "can_create_user" => $create_user,
            "can_edit_user" => $edit_user,
            "can_update_user" => 0,
            "can_assign_tasks" => $view_users,
            "can_notify_user" => $notify_user,

            "can_create_role" => $create_role,
            "can_edit_role" => $edit_role,
            "can_view_role" => $view_roles,
            "delete_role" => $delete_role,
        ]);

        return 1;
    }
    public function update(Role $role) {
        $response = Gate::allows("allowed-role-update", auth()->user());
        // dd(auth()->user()->profile->role->can_edit_role);
        if(!$response) {
            return redirect()->back();
        };
        return view("update_role", compact("role"));
    }
    public function edit(Role $role) {

        $response = Gate::allows("allowed-role-update", auth()->user());
        // dd(auth()->user()->profile->role->can_edit_role);
        if(!$response) {
            return redirect()->back();
        };

        $name = request()->get("name");
        $create_user = request()->get("create_user") === "on" ? 1 : 0;
        $edit_user = request()->get("edit_user") === "on" ? 1 : 0;
        $view_users = request()->get("view_users") === "on" ? 1 : 0;
        $delete_users = request()->get("delete_user") === "on" ? 1 : 0;

        $create_role = request()->get("create_role") === "on" ? 1 : 0;
        $edit_role = request()->get("edit_role") === "on" ? 1 : 0;
        $view_roles = request()->get("view_roles") === "on" ? 1 : 0;
        $delete_role = request()->get("delete_role") === "on" ? 1 : 0;



        $validator = Validator::make(request()->all(), [
            "name" => "required",
        ]);

        // If Validating fails 

        if($validator->fails()) {
            return response()->json(["errors" => $validator->errors()]);
        }

        $roles = $role->update([
            "name" => $name,
            "badge_color" => "#000000",
            "can_create_user" => $create_user,
            "can_edit_user" => $edit_user,
            "can_update_user" => 0,
            "can_assign_tasks" => $view_users,
            "can_notify_user" => $delete_users,

            "can_create_role" => $create_role,
            "can_edit_role" => $edit_role,
            "can_view_role" => $view_roles,
            "delete_role" => $delete_role,
        ]);

        return 1;
    }
    public function destroy(Role $role) {
        $response = Gate::allows("allowed-role-delete", auth()->user());
        if(!$response) {
            return redirect()->back();
        }
        $role->delete();
        return 1;
    }
}
