<?php

use App\Http\Controllers\Main\FeatureController;
use Illuminate\Http\Request;

$router->group(['middleware' => 'auth:api'], function ($router){

    // Fonts
    $router->get("main/features/fontawesomes", function(){
        $response = new FeatureController;
        return $response->fontawesome();
    });

    // List
    $router->post("main/features/list",function(Request $request){
        $response = new FeatureController;
        return $response->list($request);
    });

    // Create
    $router->post("main/features/create", function(Request $request){
        $response = new FeatureController;
        return $response->create($request);
    });

    // Detail
    $router->get("main/features/detail/{id}", function($id){
        $response = new FeatureController;
        return $response->detail($id);
    });

    // Update
    $router->put("main/features/update/{id}", function($id, Request $request){
        $response = new FeatureController;
        return $response->update($id, $request);
    });

    // Delete
    $router->delete("main/features/delete/{id}", function($id){
        $response = new FeatureController;
        return $response->delete($id);
    });

});

