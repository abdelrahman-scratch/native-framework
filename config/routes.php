<?php


namespace App;


use Framework\{ServiceLocator};


$router = ServiceLocator::getRouterService();

$router->addRoute("GET", "", "HomeController@index");
//$router->addRoute("GET", "test", "HomeController@index");
//$router->addRoute("DELETE", "", "HomeController@index");
$router->addRoute("GET", "testing", "ProductController@get");
$router->addRoute("GET", "register", "Auth\RegisterController@index");
$router->addRoute("POST", "register", "Auth\RegisterController@register");
$router->addRoute("GET", "login", "Auth\LoginController@index");
$router->addRoute("POST", "login", "Auth\LoginController@login");
//--------------------------------- Articles Routes --------------------------------
$router->addRoute("GET", "articles", "ArticleController@index");
$router->addRoute("GET", "articles/create", "ArticleController@create");
$router->addRoute("POST", "articles/store", "ArticleController@store");

//$router->addRoute("GET", "testing/{id}", "HelloWorldController@testWithParams");
$router->run();
