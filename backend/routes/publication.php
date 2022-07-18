<?php

use App\Http\Controllers\PublicationController;
use Illuminate\Http\Request;

$router->post('/article/list', function (Request $request) use ($router) {
    $response = new PublicationController;
    return $response->getListArticle($request);
});

$router->post('/contact/send', function (Request $request) use ($router) {
    $response = new PublicationController;
    return $response->sendContact($request);
});

$router->get('/article/categories', function () use ($router) {
    $response = new PublicationController;
    return $response->getCategories();
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

$router->get('/product/load', function () use ($router) {
    $response = new PublicationController;
    return $response->getProduct();
});

$router->get('/project/load', function () use ($router) {
    $response = new PublicationController;
    return $response->getProject();
});

$router->get("/project/find/{id}", function($id){
    $response = new PublicationController;
    return $response->getProjectById($id);
});

$router->get('/article/read/{slug}', function ($slug)  {
    $response = new PublicationController;
    return $response->getArticleBySlug($slug);
});

$router->get('/home/article', function () use ($router) {
    $response = new PublicationController;
    return $response->getHomeArticle();
});

$router->group(['middleware' => 'auth:api'], function ($router){
    $router->post("article/comment/send",function(Request $request){
        $response = new PublicationController;
        return $response->sendComment($request);
    });
});


