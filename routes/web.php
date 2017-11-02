<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->group(array("middleware" => "auth"), function() use ($router) {
    $router->get("/", function() {
        return redirect()->route("dashboard");
    });
    
    $router->get("/user/dashboard", "UserController@showDashboard");
    
    // Used to be a sweet router function that forwarded all routes with
    // a certain prefix to a controller. Not sure if Lumen still has it though.
    $router->get("/notes", "NotesController@index");
    $router->get("/notes/{id}", "NotesController@show");
    $router->post("/notes", "NotesController@store");
    $router->put("/notes/{id}", "NotesController@update");
    $router->delete("/notes/{id}", "NotesController@delete");
});

$router->get("/", function() use ($router) {
    return view("login_page");// $router->app->version();
});

$router->post("/login", "UserController@attemptLogin");

$router->get("/logout", function() {
    setcookie("token", null, 1, "/");
    return redirect("/");
});