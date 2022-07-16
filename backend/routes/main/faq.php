<?php

use App\Http\Controllers\Main\FaqController;
use Illuminate\Http\Request;

$router->group(['middleware' => 'auth:api'], function ($router){

     // Categories
    $router->get("main/faqs/categories", function(){
        $response = new FaqController;
        return $response->categories();
    });


    // List
    $router->post("main/faqs/list",function(Request $request){
        $response = new FaqController;
        return $response->list($request);
    });

    // Create
    $router->post("main/faqs/create", function(Request $request){
        $response = new FaqController;
        return $response->create($request);
    });

    // Detail
    $router->get("main/faqs/detail/{id}", function($id){
        $response = new FaqController;
        return $response->detail($id);
    });

    // Update
    $router->put("main/faqs/update/{id}", function($id, Request $request){
        $response = new FaqController;
        return $response->update($id, $request);
    });

    // Delete
    $router->delete("main/faqs/delete/{id}", function($id){
        $response = new FaqController;
        return $response->delete($id);
    });

});

