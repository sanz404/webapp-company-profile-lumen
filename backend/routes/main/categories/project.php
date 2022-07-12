<?php

use App\Http\Controllers\Main\CategoryProjectController;
use Illuminate\Http\Request;

$router->group(['middleware' => 'auth:api'], function ($router){

    // List
    $router->post("main/categories/project/list",function(Request $request){
        $response = new CategoryProjectController;
        return $response->list($request);
    });

    // Create
    $router->post("main/categories/project/create", function(Request $request){
        $response = new CategoryProjectController;
        return $response->create($request);
    });

    // Detail
    $router->get("main/categories/project/detail/{id}", function($id){
        $response = new CategoryProjectController;
        return $response->detail($id);
    });

    // Update
    $router->put("main/categories/project/update/{id}", function($id, Request $request){
        $response = new CategoryProjectController;
        return $response->update($id, $request);
    });

    // Delete
    $router->delete("main/categories/project/delete/{id}", function($id){
        $response = new CategoryProjectController;
        return $response->delete($id);
    });

});

