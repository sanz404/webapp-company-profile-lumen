<?php

use App\Http\Controllers\Main\CategoryFaqController;
use Illuminate\Http\Request;

$router->group(['middleware' => 'auth:api'], function ($router){

    // List
    $router->post("main/categories/faq/list",function(Request $request){
        $response = new CategoryFaqController;
        return $response->list($request);
    });

    // Create
    $router->post("main/categories/faq/create", function(Request $request){
        $response = new CategoryFaqController;
        return $response->create($request);
    });

    // Detail
    $router->get("main/categories/faq/detail/{id}", function($id){
        $response = new CategoryFaqController;
        return $response->detail($id);
    });

    // Update
    $router->put("main/categories/faq/update/{id}", function($id, Request $request){
        $response = new CategoryFaqController;
        return $response->update($id, $request);
    });

    // Delete
    $router->delete("main/categories/faq/delete/{id}", function($id){
        $response = new CategoryFaqController;
        return $response->delete($id);
    });

});

