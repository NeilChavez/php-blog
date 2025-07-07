<?php

namespace controller;

use Exception;
use model\User;
use MVC\Router;
use helper\FileUploader;

class UserController
{
  static function readAll(Router $router)
  {
    $users = User::getAll();
    @session_start();
    $isAdmin = isset($_SESSION["role"]) && $_SESSION["role"] === "admin";
    $router->render("/users/all-users", [
      "users" => $users,
      "isAdmin" => $isAdmin
    ]);
  }

  static function createUser(Router $router)
  {
    $user = new User();
    $errors = [];
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $user = new User($_POST);
      // the user will need to change the password following en email instructions
      $user->setPassword("default");
      $user->setAvatar("default_image.png");
      $errors = array_merge($errors, $user->validate());
      if (empty($errors)) {
        $user->createToken();
        $res = $user->sendVerificationEmail($user->email, $user->token);
        if ($res) {
          echo "mail sended";
        }
        $user->password = password_hash($user->password, PASSWORD_BCRYPT);
        $res = $user->save();
        if (!$res) {
          header("Location: /blog/error");
          exit;
        }
      }
    }
    $router->render("/dashboard/users/create", [
      "user" => $user,
      "errors" => $errors
    ]);
  }

  static function editUser(Router $router)
  {
    $id = filter_var($_GET["id"], FILTER_VALIDATE_INT);
    if (!$id) {
      throw new Exception("The user id is not valid");
    }
    /**
     * @var User $user
     */
    $user = User::find($id);
    $errors = [];
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $user->sincronize($_POST);
      $fileName = $_FILES["file"]["name"];
      ["errors" => $errors, "imageName" => $imageName] = FileUploader::upload($fileName, $user->avatar);
      $user->setAvatar($imageName);
      $errors = array_merge($errors, $user->validate());
      if (empty($errors)) {
        $user->setUpdateTime();
        $res = $user->save();
        if (!$res) {
          header("Location: /blog/error");
          exit;
        }
        header("Location: /dashboard/users?message=edited-with-success");
        exit;
      }
    }
    $router->render("/dashboard/users/update", [
      "user" => $user,
      "errors" => $errors
    ]);
  }

  static function deleteUser()
  {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $id = filter_var($_POST["id"], FILTER_VALIDATE_INT);
      if (!$id) {
        header("Location: /blog/error");
        exit;
      }
      /**
       * @var User $user
       */
      $user = User::find($id);
      if ($user) {
        $res = $user->deleteUser();
        if ($res) {
          header("Location: /dashboard/users?message=deleted-with-success");
        } else {
          header("Location: /blog/error");
        }
        exit;
      }
    }
  }
  static function findSingleUser(Router $router)
  {
    $id = filter_var($_GET["id"], FILTER_VALIDATE_INT);
    if (!$id) {
      throw new Exception("The user id is not valid");
    }
    /**
     * @var User $user
     */
    $user = User::find($id);
    $router->render("users/single-user", [
      "user" => $user
    ]);
  }
}
