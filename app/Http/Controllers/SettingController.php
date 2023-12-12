<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class SettingController extends Controller
{
    public function index() {
        return view("settings");
    }
    public function update_password() {
        $user = User::where("id", auth()->user()->id)->first();
        $old_password = request()->get("old_password");
        $new_password = request()->get("new_password");

        $errBag = [
            "status" => 1,
            "error" => [
                "old_password" => "",
                "new_password" => ""
            ]
        ];

        // Checking if the old password matches with the current password
        if(!Hash::check($old_password, $user->password)) {
            $errBag["status"] = 0;
            $errBag["error"] = [
                "old_password" => ["Old password does not match"]
            ];
        } 

        // Validatin if old_password and new_password have values

        $validation = Validator::make(request()->all(), [
            "old_password" => "required",
            "new_password" => "required|min:6|max:20"
        ]);

        // If they are empty put errors in the error bag
        if($validation->fails()) {
            $errBag["status"] = 0;
            $errors = $validation->errors()->toArray();
            $errBag["error"] = [...$errBag["error"], ...$errors];
        }
        
        // If there is no error just reset the password with the new one
        if($errBag["status"] === 1) {
            $user->update([
                "password" => Hash::make($new_password)
            ]);
        }

        return $errBag;
    }

    public function update_profile() {
        $updated_fields = [];
        $user = User::find(auth()->user()->id);
        $name = request()->get("name");
        $last_name = request()->get("last_name");
        $email = request()->get("email");
        $address = request()->get("address");

        foreach(request()->all() as $key => $value) {
            if($user[$key] !== $value) {
                array_push($updated_fields, $key);
            }
        }
        if(!count($updated_fields)) return 203;
        $validation = Validator::make(request()->all(), [
            "name" => "required|min:4",
            "last_name" => "required|min:4",
            "email" => "required|email|unique:users,email," . auth()->user()->id,
            "address" => "required|min:4|max:100"
        ]);

        if($validation->fails()) {
            return response()->json([ "errors" => $validation->errors() ]);
        }

        $user->update([
            "name" => $name,
            "last_name" => $last_name,
            "email" => $email,
            "address" => request()->get("address")
        ]);

        return 1;
    }
    public function upload_pic() {

        $validation = Validator::make(request()->all(), [
            "picture" => "required|mimes:jpg,jpeg,png"
        ]);

        if($validation->fails()) {
            return [ 
                "status" => 0,
                "errors" => $validation->errors() 
            ];
        }

        // Uploading the file image coming from the client side
        $fileName = time() . request()->picture->getClientOriginalName();
        $image = request()->file("picture");
        $file = request()->file("picture");
        $file->move(public_path('uploads'), $fileName);

        // Updating the profile picture
        $user = User::find(auth()->user()->id);
        $user->profile()->update([
            "profile_picture" => $fileName
        ]);
        return $fileName;
    }
}
