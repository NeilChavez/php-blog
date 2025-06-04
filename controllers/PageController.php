<?php

namespace controller;

use model\ActiveRecord\ActiveRecord;
use model\Post;
use MVC\Router;

class PageController
{
  static function index(Router $router)
  {
    $posts = Post::getAll();
    $router->render("/home", [
      "title" => "My blog",
      "posts" => $posts
    ]);
  }
  static function info(Router $router)
  {
    $router->render("/info");
  }
  static function aboutUs(Router $router)
  {
    $router->render("/about-us");
  }
  static function dashboard(Router $router)
  {
    $router->render("/dashboard");
  }
}
