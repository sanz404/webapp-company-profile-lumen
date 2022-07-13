<?php

use App\Http\Controllers\Main\ContentController;
use Illuminate\Http\Request;

$router->group(['middleware' => 'auth:api'], function ($router){

    // List
    $router->post("main/contents/list",function(Request $request){
        $response = new ContentController;
        return $response->list($request);
    });

    // Create
    $router->post("main/contents/create", function(Request $request){
        $response = new ContentController;
        return $response->create($request);
    });

    // Detail
    $router->get("main/contents/detail/{id}", function($id){
        $response = new ContentController;
        return $response->detail($id);
    });

    // Update
    $router->put("main/contents/update/{id}", function($id, Request $request){
        $response = new ContentController;
        return $response->update($id, $request);
    });

    // Delete
    $router->delete("main/contents/delete/{id}", function($id){
        $response = new ContentController;
        return $response->delete($id);
    });

});

