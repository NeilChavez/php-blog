<?php

namespace controller;

use model\User;
use MVC\Router;

class UserController
{
  static function readAll(Router $router)
  {
    $users = User::getAll();
    $router->render("/users/all-users", [
      "users" => $users
    ]);
  }
}
