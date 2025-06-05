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
        $passMatches = password_verify($passwordEntered, $user->password);
        if ($user && $passMatches) {
          session_start();
          $_SESSION["user"] = $user->username;
          $_SESSION["email"] = $user->email;
          $_SESSION["role"] = $user->role;
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
