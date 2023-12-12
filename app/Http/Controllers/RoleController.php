<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function index() {
        $roles = Role::paginate(5);
        return view("roles", compact("roles"));
    }
    public function create() {
        return view("create_role");
    }
    public function store() {
        $name = request()->get("name");
        $create_user = request()->get("create_user") === "on" ? 0 : 1;
        $edit_user = request()->get("edit_user") === "on" ? 0 : 1;
        $assign_tasks = request()->get("assign_task") === "on" ? 0 : 1;
        $notify_user = request()->get("notify_user") === "on" ? 0 : 1;

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
            "can_assign_tasks" => $assign_tasks,
            "can_notify_user" => $notify_user,
        ]);

        return 1;
    }
    public function update(Role $role) {
        return view("update_role", compact("role"));
    }
    public function edit(Role $role) {
        $name = request()->get("name");
        $create_user = request()->get("create_user") === "on" ? 1 : 0;
        $edit_user = request()->get("edit_user") === "on" ? 1 : 0;
        $assign_tasks = request()->get("assign_task") === "on" ? 1 : 0;
        $notify_user = request()->get("notify_user") === "on" ? 1 : 0;

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
            "can_assign_tasks" => $assign_tasks,
            "can_notify_user" => $notify_user,
        ]);

        return 1;
    }
    public function destroy(Role $role) {
        $role->delete();
        return 1;
    }
}
