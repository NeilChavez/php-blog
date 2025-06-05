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
      if ($emailAlreadyExists) {
        $errors[] = "Email already exists.";
      }
      //check if the usersname is already used
      $usernameAlreadyUsed = User::findBy(["username" => $user->username]);
      if ($usernameAlreadyUsed) {
        $errors[] = "Username already exists.";
      }
      if (empty($errors)) {
        $user->createToken();
        $res = $user->sendVerificationEmail($user->email, $user->token);
        if($res){
          echo "mail sended";
        }
        $user->createUser();
      }
    }
    $router->render("/sign-up", [
      "errors" => $errors,
      "user" => $user
    ]);
  }
  
  static function checkYouEmail(Router $router)
  {
    $router->render("/check-your-email");
  }
  
  static function activateUser(Router $router)
  {
    $token = $_GET["token"];
    /**
     * @var User $user 
     */
    $user = User::findBy(["token" => $token]);
    if(!$user){
      throw new Exception("Token not valid");
    }
    //activated user will have 1 setted as token to communicate that user has confirmed the email
    $user->token = 1;
    $user->save();
    $router->render("/activate-user");
  }
}
