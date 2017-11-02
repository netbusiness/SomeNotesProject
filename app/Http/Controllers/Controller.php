<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Firebase\JWT\JWT;

class Controller extends BaseController {
    protected function updateAuthTokenCookie() {
        if (\Auth::user() != null && !empty($_COOKIE['token'])) {
            $payload = array(
                "nbf" => time() - 10,
                "exp" => time() + 3600,
                "userID" => \Auth::user()->id
            );
            
            $jwt = JWT::encode($payload, $_ENV['APP_KEY']);
            
            setcookie("token", $jwt, time() + 3600, "/");
        }
    }
}
