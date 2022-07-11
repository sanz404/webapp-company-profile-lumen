<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\NotificationController;
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

    // Detail Notification
    $router->get("account/notifications/detail/{id}",function($id){
        $response = new NotificationController;
        return $response->detail($id);
    });

    // Delete Notification
    $router->delete("account/notifications/delete/{id}",function($id){
        $response = new NotificationController;
        return $response->delete($id);
    });

     // Current Notification
     $router->get("account/notifications/current",function(){
        $response = new NotificationController;
        return $response->current();
    });

    // List Notification Datatable
    $router->post("account/notifications/list",function(Request $request){
        $response = new NotificationController;
        return $response->list($request);
    });


});

