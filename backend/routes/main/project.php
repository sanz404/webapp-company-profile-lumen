<?php

use App\Http\Controllers\Main\ProjectController;
use Illuminate\Http\Request;

$router->group(['middleware' => 'auth:api'], function ($router){

     // Categories
    $router->get("main/projects/categories", function(){
        $response = new ProjectController;
        return $response->categories();
    });


    // List
    $router->post("main/projects/list",function(Request $request){
        $response = new ProjectController;
        return $response->list($request);
    });

    // Create
    $router->post("main/projects/create", function(Request $request){
        $response = new ProjectController;
        return $response->create($request);
    });

    // Detail
    $router->get("main/projects/detail/{id}", function($id){
        $response = new ProjectController;
        return $response->detail($id);
    });

    // Update
    $router->put("main/projects/update/{id}", function($id, Request $request){
        $response = new ProjectController;
        return $response->update($id, $request);
    });

    // Delete
    $router->delete("main/projects/delete/{id}", function($id){
        $response = new ProjectController;
        return $response->delete($id);
    });

});

