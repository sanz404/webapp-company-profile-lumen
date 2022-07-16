<?php

use App\Http\Controllers\PublicationController;
use Illuminate\Http\Request;

$router->post('/contact/send', function (Request $request) use ($router) {
    $response = new PublicationController;
    return $response->sendContact($request);
});


$router->get('/content/load', function () use ($router) {
    $response = new PublicationController;
    return $response->getContent();
});

$router->get('/feature/load', function () use ($router) {
    $response = new PublicationController;
    return $response->getFeature();
});
