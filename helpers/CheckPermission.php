<?php

namespace helper;

use model\User;

class CheckPermission
{
  public static function getCurrentIdAndRoleUser()
  {
    list($id, $role) = self::isLoggedIn();
    $user = new User([
      "id" => $id,
      "role" => $role
    ]);
    return $user;
  }
  public static function isLoggedIn()
  {
    @session_start();
    $id = null;
    $role = null;
    if (isset($_SESSION["id"]) && isset($_SESSION["role"])) {
      $id = $_SESSION["id"];
      $role = $_SESSION["role"];
    } else {
      header("Location: /login");
      exit;
    }
    return [$id, $role];
  }

  static function canEdit($entity)
  {
    $user = self::getCurrentIdAndRoleUser();
    // check if the user is autorized to change the content
    $isAdmin = $user->role === "admin";
    if (!$isAdmin && $user->id !== $entity->user_id) {
      http_response_code(403);
      header("Location: /blog/not-authorized");
      exit;
    }
    return true;
  }
  static function canDelete($entity)
  {
    $user = self::getCurrentIdAndRoleUser();
    // check if the user is autorized to change the content
    $isAdmin = $user->role === "admin";
    if (!$isAdmin && $user->id !== $entity->user_id) {
      http_response_code(403);
      header("Location: /blog/not-authorized");
      exit;
    }
    return true;
  }
  static function canCreate()
  {
    $user = self::getCurrentIdAndRoleUser();
    // check if the user is autorized to change the content
    $canCreateComment = $user->role === "admin" || "author" || "subscriber";
    if (!$canCreateComment) {
      http_response_code(403);
      header("Location: /blog/login");
      exit;
    }
    return true;
  }
}
