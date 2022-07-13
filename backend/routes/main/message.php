<?php

use App\Http\Controllers\Main\MessageController;
use Illuminate\Http\Request;

$router->group(['middleware' => 'auth:api'], function ($router){

    // List
    $router->post("main/messages/list",function(Request $request){
        $response = new MessageController;
        return $response->list($request);
    });

    // Detail
    $router->get("main/messages/detail/{id}", function($id){
        $response = new MessageController;
        return $response->detail($id);
    });

});

