<?php

use App\Http\Controllers\Main\ProductController;
use Illuminate\Http\Request;

$router->group(['middleware' => 'auth:api'], function ($router){

     // Categories
    $router->get("main/products/categories", function(){
        $response = new ProductController;
        return $response->categories();
    });


    // List
    $router->post("main/products/list",function(Request $request){
        $response = new ProductController;
        return $response->list($request);
    });

    // Create
    $router->post("main/products/create", function(Request $request){
        $response = new ProductController;
        return $response->create($request);
    });

    // Detail
    $router->get("main/products/detail/{id}", function($id){
        $response = new ProductController;
        return $response->detail($id);
    });

    // Update
    $router->put("main/products/update/{id}", function($id, Request $request){
        $response = new ProductController;
        return $response->update($id, $request);
    });

    // Delete
    $router->delete("main/products/delete/{id}", function($id){
        $response = new ProductController;
        return $response->delete($id);
    });

});

