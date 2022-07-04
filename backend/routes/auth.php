<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;

// Login
$router->post("auth/login",function(Request $request){
    $response = new AuthController;
    return $response->login($request);
});

// Logout
$router->post('auth/logout',['middlware' => 'auth:api', function (Request $request) {
    $response = new AuthController;
    return $response->logout($request);
}]);

// Register
$router->post("auth/register",function(Request $request){
    $response = new AuthController;
    return $response->register($request);
});

// Confirmation
$router->post("auth/confirm",function(Request $request){
    $response = new AuthController;
    return $response->confirm($request);
});

// Forgot Password
$router->post("auth/forgot_password",function(Request $request){
    $response = new AuthController;
    return $response->forgot_password($request);
});

// Reset Password
$router->post("auth/reset_password",function(Request $request){
    $response = new AuthController;
    return $response->reset_password($request);
});



