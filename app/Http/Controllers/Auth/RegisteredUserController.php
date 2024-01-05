<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function registration_code() {
        return view("auth.register");
    }
    public function check_uuid(Request $request, $uuid) {
        $code = $uuid;
        $user = User::where("registration_code", $code)->first();

        if(!$user) {
            return to_route("login");
        }
        
        session()->put("registering_user", $user);
        session()->put("code", $code);

        return redirect()->to(route("personal_info"));
    }
    public function personal_info() {
        if(!session()->has("registering_user")) {
            return redirect()->to(route("register"));
        }
        return view("auth.personal_info");
    }
    public function store_personal_info(Request $request) {
        $request->validate([
            "email" => "required|email|unique:users",
            "address" => "required",
        ]);

        $personal_details = [
            "email" => $request->get("email"),
            "address" => $request->get("address")
        ];

        session()->put("personal_info", $personal_details);
        return redirect()->to("security_info");
    }
    public function security_info() {
        if(!session()->has("personal_info")) {
            return redirect()->to(route("register"));
        }
        return view("auth.security_info");
    }
    public function store_security_info(Request $request) {
        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = session()->get("registering_user");
        $personal_info = session()->get("personal_info");

        $user->update([
            "email" => $personal_info["email"],
            "address" => $personal_info["address"],
            "password" => Hash::make($request->get("password")),
            "registration_code" => ""
        ]);

        Notification::create([
            "user_id" => $user->id,
            "message" => "[]",
            "isRead" => true
        ]);

        session()->regenerate(true);

        return redirect()->to(route("login"));
    }
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'address' => $request->address,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
