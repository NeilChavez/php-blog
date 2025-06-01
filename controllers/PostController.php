<?php

namespace controller;

use model\Post;
use MVC\Router;
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
    $post = Post::find($id);
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
      //file validations
      if (!count($_FILES) > 0) {
        $errors[] = "You need to upload an image";
      }
      if ($_FILES["file"]["size"] > 8388608) {
        $errors[] = "The file uploaded is too big, max 8MB";
      }
      $allowedFiles = ["image/jpeg", "image/jpg", "image/png", "image/gif"];
      if (!$post->featured_image && !in_array($_FILES["file"]["type"], $allowedFiles)) {
        $errors[] = "The format is not valid";
      }
      //upload image only if it passes validations
      if (!count($errors) > 0) {
        //upload new file
        $fileImageName = $_FILES["file"]["name"];
        //generate directory for images
        $imagesPath =  $_SERVER["DOCUMENT_ROOT"] . "/src/images/";
        if (!is_dir($imagesPath)) {
          mkdir($imagesPath);
        }
        if ($fileImageName) {
          $oldImage = $imagesPath . $post->featured_image;
          //if the post entity has already an image and the user want to upload a new image, so we need to delete the "old" image
          if ($post->featured_image) {
            is_file($oldImage) && unlink($oldImage);
          }
          $temp = $_FILES["file"]["tmp_name"];
          $manager = new ImageManager(new Driver());
          $image = $manager->read($temp);
          $randomName = uniqid(rand(), true) . ".jpeg";
          $image->save($imagesPath . $randomName);
          $post->setImage($randomName);
        }
      }
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
     if($_SERVER["REQUEST_METHOD"] === "POST"){
       $post->sincronize($_POST);
      //file validations
      if (!count($_FILES) > 0) {
        $errors[] = "You need to upload an image";
      }
      if ($_FILES["file"]["size"] > 8388608) {
        $errors[] = "The file uploaded is too big, max 8MB";
      }
      $allowedFiles = ["image/jpeg", "image/jpg", "image/png", "image/gif"];
      if (!$post->featured_image && !in_array($_FILES["file"]["type"], $allowedFiles)) {
        $errors[] = "The format is not valid";
      }
      //upload image only if it passes validations
      if (!count($errors) > 0) {
        //upload new file
        $fileImageName = $_FILES["file"]["name"];
        //generate directory for images
        $imagesPath =  $_SERVER["DOCUMENT_ROOT"] . "/src/images/";
        if (!is_dir($imagesPath)) {
          mkdir($imagesPath);
        }
        if ($fileImageName) {
          $oldImage = $imagesPath . $post->featured_image;
          //if the post entity has already an image and the user want to upload a new image, so we need to delete the "old" image
          if ($post->featured_image) {
            is_file($oldImage) && unlink($oldImage);
          }
          $temp = $_FILES["file"]["tmp_name"];
          $manager = new ImageManager(new Driver());
          $image = $manager->read($temp);
          $randomName = uniqid(rand(), true) . ".jpeg";
          $image->save($imagesPath . $randomName);
          $post->setImage($randomName);
        }
      }
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
    if(!$post){
      echo "Post Not Founded";
      return;
    }
    $post->deletePost();
  }
}
