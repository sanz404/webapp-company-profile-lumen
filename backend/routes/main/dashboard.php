<?php

use App\Http\Controllers\Main\DashboardController;
use Illuminate\Http\Request;

$router->group(['middleware' => 'auth:api'], function ($router){

    // Content Dashboard
    $router->get("main/dashboard/content", function(){
        $response = new DashboardController;
        return $response->content();
    });

});

