<?php

namespace controller;

use helper\CheckPermission;
use model\Post;
use model\User;
use MVC\Router;
use helper\FileUploader;
use model\Category;

class PostController
{
  static function readAll(Router $router)
  {
    $posts = Post::getAll();
    $router->render("/dashboard/posts/all-posts", [
      "posts" => $posts
    ]);
  }

  static function findSinglePost(Router $router)
  {
    $id = filter_var($_GET["id"], FILTER_VALIDATE_INT);
    if (!$id) throw new \Exception("Post ID not valid");
    $post = Post::withComments($id);
    $router->render(
      "/blog/post",
      [
        "post" => $post
      ]
    );
  }
  static function createPost(Router $router)
  {
    CheckPermission::canDoAction("create", "post");
    $post = new Post();
    $categories = Category::getAll();
    $errors = [];
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $post = new Post($_POST);
      $fileName = $_FILES["file"]["name"];
      ["errors" => $errors, "imageName" => $imageName] = FileUploader::upload($fileName, $post->featured_image);
      $post->setImage($imageName);
      $errors = array_merge($post->validate(), $errors);
      if (empty($errors)) {
        $post->savePost();
      }
    }
    $router->render("/dashboard/posts/create", [
      "errors" => $errors,
      "post" => $post,
      "categories" => $categories
    ]);
  }

  static function editPost(Router $router)
  {
    $post = new Post;
    $id = filter_var($_GET["id"], FILTER_VALIDATE_INT);
    if (!$id) throw new \Exception("Post ID not valid");
    /**
     * @var Post $post
     */
    $post = Post::find($id);
    $errors = [];
    CheckPermission::canDoAction("edit", "post", $post);
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $post->sincronize($_POST);
      $fileName = $_FILES["file"]["name"];
      ["errors" => $errors, "imageName" => $imageName] = FileUploader::upload($fileName, $post->featured_image);
      $post->setImage($imageName);
      $errors = array_merge($post->validate(), $errors);
      if (empty($errors)) {
        $post->setUpdateTime();
        $post->savePost();
      }
    }
    $router->render("/dashboard/posts/update", [
      "errors" => $errors,
      "post" => $post,
    ]);
  }

  static function deletePost()
  {
    $id = filter_var($_GET["id"], FILTER_VALIDATE_INT);
    if (!$id) throw new \Exception("ID not valid");
    /**
     * @var Post $post
     */
    $post = Post::find($id);
    // check the permission 
    CheckPermission::canDoAction("delete", "post", $post);
    if (!$post) {
      echo "Post Not Founded";
      return;
    }
    $post->deletePost();
  }
}
