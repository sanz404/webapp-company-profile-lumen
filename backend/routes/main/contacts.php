<?php

use App\Http\Controllers\Main\ContactController;
use Illuminate\Http\Request;

$router->group(['middleware' => 'auth:api'], function ($router){

    // List
    $router->post("main/contacts/list",function(Request $request){
        $response = new ContactController;
        return $response->list($request);
    });

    // Create
    $router->post("main/contacts/create", function(Request $request){
        $response = new ContactController;
        return $response->create($request);
    });

    // Detail
    $router->get("main/contacts/detail/{id}", function($id){
        $response = new ContactController;
        return $response->detail($id);
    });

    // Update
    $router->put("main/contacts/update/{id}", function($id, Request $request){
        $response = new ContactController;
        return $response->update($id, $request);
    });

    // Delete
    $router->delete("main/contacts/delete/{id}", function($id){
        $response = new ContactController;
        return $response->delete($id);
    });

});

