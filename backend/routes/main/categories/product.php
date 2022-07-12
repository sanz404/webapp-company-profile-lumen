<?php

use App\Http\Controllers\Main\CategoryProductController;
use Illuminate\Http\Request;

$router->group(['middleware' => 'auth:api'], function ($router){

    // List
    $router->post("main/categories/product/list",function(Request $request){
        $response = new CategoryProductController;
        return $response->list($request);
    });

    // Create
    $router->post("main/categories/product/create", function(Request $request){
        $response = new CategoryProductController;
        return $response->create($request);
    });

    // Detail
    $router->get("main/categories/product/detail/{id}", function($id){
        $response = new CategoryProductController;
        return $response->detail($id);
    });

    // Update
    $router->put("main/categories/product/update/{id}", function($id, Request $request){
        $response = new CategoryProductController;
        return $response->update($id, $request);
    });

    // Delete
    $router->delete("main/categories/product/delete/{id}", function($id){
        $response = new CategoryProductController;
        return $response->delete($id);
    });

});

