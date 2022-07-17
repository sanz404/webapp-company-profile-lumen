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

$router->get('/about/load', function () use ($router) {
    $response = new PublicationController;
    return $response->getAbout();
});

$router->get('/team/load', function () use ($router) {
    $response = new PublicationController;
    return $response->getTeam();
});

$router->get('/faq/load', function () use ($router) {
    $response = new PublicationController;
    return $response->getFaq();
});

$router->get('/home/article', function () use ($router) {
    $response = new PublicationController;
    return $response->getHomeArticle();
});

