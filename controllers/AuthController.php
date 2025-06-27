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
      if (!$user->email ||  !$user->password) {
        $errors[] = "fields are not completed";
      }
      if (empty($errors)) {
        $passwordEntered = $user->password;
        /**
         * @var User|bool $user
         */
        $user = User::findBy(["email" => $user->email]);
        $passwordMatches = password_verify($passwordEntered, $user->password);
        if (!$user || !$passwordMatches) {
          $errors[] = "Some of your info isn't correct. Please try again.";
        } elseif ($user && !$user->isConfirmedUser()) {
          header("Location: /blog/
          -your-email");
          exit;
        } elseif ($passwordMatches) {
          session_start();
          $_SESSION["id"] = $user->id;
          $_SESSION["user"] = $user->username;
          $_SESSION["email"] = $user->email;
          $_SESSION["role"] = $user->role;
          header("Location: /dashboard");
          exit;
        }
      }
    }
    $router->render("/blog/login", [
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
