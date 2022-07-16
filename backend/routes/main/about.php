<?php

use App\Http\Controllers\Main\AboutController;
use Illuminate\Http\Request;

$router->group(['middleware' => 'auth:api'], function ($router){

    // List
    $router->post("main/abouts/list",function(Request $request){
        $response = new AboutController;
        return $response->list($request);
    });

    // Create
    $router->post("main/abouts/create", function(Request $request){
        $response = new AboutController;
        return $response->create($request);
    });

    // Detail
    $router->get("main/abouts/detail/{id}", function($id){
        $response = new AboutController;
        return $response->detail($id);
    });

    // Update
    $router->put("main/abouts/update/{id}", function($id, Request $request){
        $response = new AboutController;
        return $response->update($id, $request);
    });

    // Delete
    $router->delete("main/abouts/delete/{id}", function($id){
        $response = new AboutController;
        return $response->delete($id);
    });

});

