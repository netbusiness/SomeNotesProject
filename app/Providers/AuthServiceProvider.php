<?php

namespace App\Providers;

use App\User;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function ($request) {
            if ($request->has("t")) {
                $token = $request->input("t");
            } elseif ($request->headers->has("Authorization")) {
                $token = $request->headers->get("Authorization");
                $token = substr($token, 7);
            } elseif (!empty($_COOKIE['token'])) {
                $token = $_COOKIE['token'];
            } else {
                return null;
            }
            
            // $payload = null;
            try {
                $payload = JWT::decode($token, $_ENV['APP_KEY'], array("HS256"));
                
                return User::find($payload->userID)->first();
            } catch (\Exception $ex) {
                // Doesn't really matter what the error is, they're not getting in
                return null;
            }
            
            return null;
        });
    }
}
