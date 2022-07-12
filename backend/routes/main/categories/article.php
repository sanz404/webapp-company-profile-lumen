<?php

use App\Http\Controllers\Main\CategoryArticleController;
use Illuminate\Http\Request;

$router->group(['middleware' => 'auth:api'], function ($router){

    // List
    $router->post("main/categories/article/list",function(Request $request){
        $response = new CategoryArticleController;
        return $response->list($request);
    });

    // Create
    $router->post("main/categories/article/create", function(Request $request){
        $response = new CategoryArticleController;
        return $response->create($request);
    });

    // Detail
    $router->get("main/categories/article/detail/{id}", function($id){
        $response = new CategoryArticleController;
        return $response->detail($id);
    });

    // Update
    $router->put("main/categories/article/update/{id}", function($id, Request $request){
        $response = new CategoryArticleController;
        return $response->update($id, $request);
    });

    // Delete
    $router->delete("main/categories/article/delete/{id}", function($id){
        $response = new CategoryArticleController;
        return $response->delete($id);
    });

});

