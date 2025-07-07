<?php

namespace controller;

use model\Post;
use model\User;
use MVC\Router;
use model\Comment;
use model\Category;

class PageController
{
  static function index(Router $router)
  {
    $posts = Post::where("status", "published");
    $categories = Category::getAll();
    $featuredPosts = array_slice($posts, 3, 3);
    $router->render("blog/home", [
      "title" => "My blog",
      "posts" => $posts,
      "categories" => $categories,
      "featuredPosts" => $featuredPosts
    ]);
  }
  static function info(Router $router)
  {
    $router->render("/blog/info");
  }
  static function aboutUs(Router $router)
  {
    $router->render("/blog/about-us");
  }

  public static function byCategories(Router $router)
  {
    $id = $_GET["id"] ?? "";
    $category = $_GET["category"] ?? "";
    $id = filter_var($id, FILTER_VALIDATE_INT);
    $posts = Post::findByCategory($id);
    $router->render("/blog/by-category", [
      "category" => $category,
      "posts" => $posts
    ]);
  }

  static function notAuthorized(Router $router)
  {
    $router->render("/blog/not-authorized");
  }
}
