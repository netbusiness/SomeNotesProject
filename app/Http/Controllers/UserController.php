<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;

class UserController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        //
    }
    
    public function attemptLogin(Request $request) {
        $rules = array(
            "email" => "required|email",
            "password" => "required"
        );
        
        $this->validate($request, $rules);
        
        $user = User::where("email", $request->email)->first();
        
        if ($user != null) {
            if (password_verify($request->password, $user->password)) {
                // Success!
                $payload = array(
                    "nbf" => time() - 10,
                    "exp" => time() + 3600,
                    "userID" => $user->id
                );
                
                $jwt = JWT::encode($payload, $_ENV['APP_KEY']);
                
                return response()->json(array(
                    "success" => array(
                        "token" => $jwt
                    )
                ));
            }
        }
        
        return response()->json(array(
            "error" => array(
                "You've entered a bad email or password"
            )
        ));
    }

    public function showDashboard() {
        return view("user_dashboard");
    }
}
