<?php

namespace controller;

use model\Post;
use MVC\Router;
use model\Comment;
use helper\FileUploader;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class PostController
{
  static function readAll(Router $router)
  {
    $posts = Post::getAll();

    $router->render("/post/all-posts", [
      "posts" => $posts
    ]);
  }

  static function findSinglePost(Router $router)
  {
    $id = filter_var($_GET["id"], FILTER_VALIDATE_INT);
    if (!$id) throw new \Exception("Post ID not valid");
    $post = Post::withComments($id);
    $router->render(
      "/post",
      [
        "post" => $post
      ]
    );
  }
  static function createPost(Router $router)
  {
    $post = new Post();
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
    $router->render("/post/create", [
      "errors" => $errors,
      "post" => $post
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
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $post->sincronize($_POST);
      $fileName = $_FILES["file"]["name"];
      ["errors" => $errors, "imageName" => $imageName] = FileUploader::upload($fileName, $post->featured_image);
      $post->setImage($imageName);
      $errors = array_merge($post->validate(), $errors);
      if (empty($errors)) {
        $post->savePost();
      }
    }
    $router->render("/post/update", [
      "errors" => $errors,
      "post" => $post
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
    if (!$post) {
      echo "Post Not Founded";
      return;
    }
    $post->deletePost();
  }
}
