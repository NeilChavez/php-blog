<?php

namespace controller;

use model\User;
use MVC\Router;

class AuthController
{
  static function login(Router $router)
  {
    $errors = [];
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $user = new User($_POST); 
      if(!$user->email ||  !$user->password){
        $errors[] = "fields are not completed";
      }
      if (empty($errors)) {
        /**
         * @var User|bool $user
         */
        $user = User::findBy(["email" => $user->email, "password" => $user->password]);
        if ($user) {
          session_start();
          $_SESSION["user"] = $user->username;
          $_SESSION["email"] = $user->email;
          header("Location: /dashboard?username=$user->username");
        } else {
          $errors[] = "Your credential are not correct.";
        }
      }
    }
    $router->render("/login", [
      "errors" => $errors
    ]);
  }

  static function logout()
  {
    session_start();
    session_destroy();
    $_SESSION = [];
    header("Location: /");
  }
}
