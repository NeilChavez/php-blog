<?php

namespace controller;

use MVC\Router;
use model\Post;
use model\User;
use model\Comment;
use model\Category;

class DashboardController
{
  static function index(Router $router)
  {
    $data = [];
    $isAdmin = $_SESSION["role"] === "admin";
    $criteria = ["limit" => 3, "order" => "created_at desc"];
    if (!$isAdmin) {
      $criteria["where"] = "status = 'published'";
    } else {
      ["posts" => $postsCount] = Post::count();
      ["users" => $usersCount] = User::count();
      ["comments" => $commentsCount] = Comment::count();
      ["categories" => $categoriesCount] = Category::count();
      $data = [
        "postCount" => $postsCount,
        "usersCount" => $usersCount,
        "commentsCount" => $commentsCount,
        "categoriesCount" => $categoriesCount,
      ];
    }
    $lastsPosts = Post::getAll($criteria);
    $lastsComments = Comment::getAll($criteria);
    $router->render("/dashboard/home", [
      "isAdmin" => $isAdmin,
      "data" => $data,
      "lastsPosts" => $lastsPosts,
      "lastsComments" => $lastsComments
    ]);
  }
  static function posts(Router $router)
  {
    $isAdmin = $_SESSION["role"] === "admin";
    $userId = $_SESSION["id"];
    $posts = [];
    if ($isAdmin) {
      $posts = Post::getAll(["order" => "updated_at desc"]);
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
      $comments = Comment::getAll(["order" => "created_at desc"]);
    } else {
      $comments = Comment::where("user_id", $userId);
    }
    $router->render("dashboard/comments/all-comments", [
      "comments" => $comments
    ]);
  }

  static function users(Router $router)
  {
    $users = User::getAll(["order" => "updated_at desc"]);
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
