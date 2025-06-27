<?php

namespace controller;

use Exception;
use model\User;
use MVC\Router;

class SignUpController
{

  static function signUp(Router $router)
  {
    $user = new User();
    $errors = [];
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $user = new User($_POST);
      $errors = $user->validate();
      //check if the user already exists
      $emailAlreadyExists = User::findBy(["email" => $user->email]);
      $usernameAlreadyUsed = User::findBy(["username" => $user->username]);
      if ($usernameAlreadyUsed || $emailAlreadyExists) {
        $errors[] = "Username or email already exists.";
      }
      if (empty($errors)) {
        $user->createToken();
        $user->password = password_hash($user->password, PASSWORD_BCRYPT);
        $res = $user->save();
        if (!$res) {
          header("Location: /blog/error");
          exit;
        }
        $res = $user->sendVerificationEmail($user->email, $user->token);
        if ($res) {
          header("Location: /blog/check-your-email");
          exit;
        }
      }
    }
    $router->render("/blog/sign-up", [
      "errors" => $errors,
      "user" => $user
    ]);
  }

  static function checkYouEmail(Router $router)
  {
    $router->render("/blog/check-your-email");
  }

  static function activateUser(Router $router)
  {
    $token = $_GET["token"];
    /**
     * @var User $user 
     */
    $user = User::findBy(["token" => $token]);
    if (!$user) {
      throw new Exception("Token not valid");
    }
    //activated user will have 1 setted as token to communicate that user has confirmed the email
    $user->token = 1;
    $user->save();
    $router->render("/blog/activate-user");
  }
}
