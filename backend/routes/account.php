<?php

use App\Http\Controllers\AccountController;
use Illuminate\Http\Request;

$router->group(['middleware' => 'auth:api'], function ($router){

    // Update Password
    $router->post("account/password/update",function(Request $request){
        $response = new AccountController;
        return $response->passwordUpdate($request);
    });

    // Current Profile
    $router->post("account/profile",function(Request $request){
        $response = new AccountController;
        return $response->getAuthUser($request);
    });

    // Update Account
    $router->post("account/profile/update",function(Request $request){
        $response = new AccountController;
        return $response->updateAuthUser($request);
    });

    // List Countries
    $router->get("account/countries",function(){
        $response = new AccountController;
        return $response->getCountries();
    });

});

