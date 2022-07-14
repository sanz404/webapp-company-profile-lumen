<?php

use App\Http\Controllers\Main\TeamController;
use Illuminate\Http\Request;

$router->group(['middleware' => 'auth:api'], function ($router){

    // List
    $router->post("main/teams/list",function(Request $request){
        $response = new TeamController;
        return $response->list($request);
    });

    // Create
    $router->post("main/teams/create", function(Request $request){
        $response = new TeamController;
        return $response->create($request);
    });

    // Detail
    $router->get("main/teams/detail/{id}", function($id){
        $response = new TeamController;
        return $response->detail($id);
    });

    // Update
    $router->put("main/teams/update/{id}", function($id, Request $request){
        $response = new TeamController;
        return $response->update($id, $request);
    });

    // Delete
    $router->delete("main/teams/delete/{id}", function($id){
        $response = new TeamController;
        return $response->delete($id);
    });

});

