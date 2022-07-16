<?php

use App\Http\Controllers\Main\ArticleController;
use Illuminate\Http\Request;

$router->group(['middleware' => 'auth:api'], function ($router){

     // Categories
    $router->get("main/articles/categories", function(){
        $response = new ArticleController;
        return $response->categories();
    });


    // List
    $router->post("main/articles/list",function(Request $request){
        $response = new ArticleController;
        return $response->list($request);
    });

    // Create
    $router->post("main/articles/create", function(Request $request){
        $response = new ArticleController;
        return $response->create($request);
    });

    // Detail
    $router->get("main/articles/detail/{id}", function($id){
        $response = new ArticleController;
        return $response->detail($id);
    });

    // Update
    $router->put("main/articles/update/{id}", function($id, Request $request){
        $response = new ArticleController;
        return $response->update($id, $request);
    });

    // Delete
    $router->delete("main/articles/delete/{id}", function($id){
        $response = new ArticleController;
        return $response->delete($id);
    });

});

