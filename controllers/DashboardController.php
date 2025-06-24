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
    $isAdmin = $_SESSION["role"] === "admin";
    $userId = $_SESSION["id"];
    $posts = [];
    if ($isAdmin) {
      $posts = Post::getAll();
    } else {
      $posts = Post::where("user_id", $userId);
    }
    $categories = Category::getAll();
    $router->render("dashboard/posts/all-posts", [
      "posts" => $posts,
      "categories" => $categories
    ]);
  }

  static function categories(Router $router)
  {
    $categories = Category::getAll();
    $router->render("dashboard/categories/all-categories", [
      "categories" => $categories
    ]);
  }

  

  static function comments(Router $router)
  {
    $isAdmin = $_SESSION["role"] === "admin";
    $userId = $_SESSION["id"];
    $comments = [];
    if ($isAdmin) {
      $comments = Comment::getAll();
    } else {
      $comments = Comment::where("user_id", $userId);
    }
    $router->render("dashboard/comments/all-comments", [
      "comments" => $comments
    ]);
  }

  static function users(Router $router)
  {
    $users = User::getAll();
    $router->render("dashboard/users/all-users", [
      "users" => $users
    ]);
  }


  static function commentsToApprove(Router $router)
  {
    $cammentsToApprove = Comment::findBy(["status" => "draft"]);
    $router->render("dashboard/comments/to-approve", [
      "cammentsToApprove" => $cammentsToApprove
    ]);
  }
}
