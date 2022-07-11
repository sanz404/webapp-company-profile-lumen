<?php

use App\Http\Controllers\Main\UserCOntroller;
use Illuminate\Http\Request;

$router->group(['middleware' => 'auth:api'], function ($router){

    // List
    $router->post("main/users/list",function(Request $request){
        $response = new UserCOntroller;
        return $response->list($request);
    });

    // Create
    $router->post("main/users/create", function(Request $request){
        $response = new UserCOntroller;
        return $response->create($request);
    });

    // Detail
    $router->get("main/users/detail/{id}", function($id){
        $response = new UserCOntroller;
        return $response->detail($id);
    });

    // Update
    $router->put("main/users/update/{id}", function($id, Request $request){
        $response = new UserCOntroller;
        return $response->update($id, $request);
    });

    // Delete
    $router->delete("main/users/delete/{id}", function($id){
        $response = new UserCOntroller;
        return $response->delete($id);
    });

});

