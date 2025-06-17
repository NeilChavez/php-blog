<?php

namespace controller;

use MVC\Router;
use model\Post;
use model\User;
use model\Comment;
use model\Category;

class DashboardController
{
  static function posts(Router $router)
  {

    $posts = Post::getAll();
    $router->render("dashboard/posts", [
      "posts" => $posts
    ]);
  }

  static function categories(Router $router)
  {
    $categories = Category::getAll();
    $router->render("dashboard/categories", [
      "categories" => $categories
    ]);
  }

  static function comments(Router $router)
  {
    $camments = Comment::getAll();
    $router->render("dashboard/comments", [
      "comments" => $camments
    ]);
  }

  static function users(Router $router)
  {
    $users = User::getAll();
    $router->render("dashboard/users", [
      "users" => $users
    ]);
  }


  static function commentsToApprove(Router $router)
  {
    $cammentsToApprove = Comment::findBy(["status" => "draft"]);
    $router->render("dashboard/comments", [
      "cammentsToApprove" => $cammentsToApprove
    ]);
  }
}
