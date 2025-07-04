<?php

namespace helper;

use model\User;

class CheckPermission
{
  const PERMISSIONS = [
    "post" => [
      "create" => ["admin", "author"],
      "edit" => ["admin", "author"], // and the owner
      "delete" => ["admin", "author"] // and the owner
    ],
    "comment" => [
      "edit" => ["admin", "author", "subscriber"],
      "create" => ["admin", "author", "subscriber"],
      "delete" => ["admin"], // and owner
      "change-status" => ["admin"], // and owner
    ]
  ];
  public static function canEditPost($entity, $action)
  {
    $user = self::getCurrentIdAndRoleUser();
    // retrieve the group that can edit the post
    $allowedGruop = self::PERMISSIONS["post"][$action];
    $isInAllowedGroup = in_array($user->role, $allowedGruop);
    // check if the user is the owner of the post
    $isOwner = $user->id === $entity->user_id;
    // redirect if user role is not in ["admin", "author"]
    // AND if user is not the owner of the post
    if (!$isInAllowedGroup && !$isOwner) {
      self::redirectToNotAuthorized();
    }
    return true;
  }

  public static function canCreatePost()
  {
    $user = self::getCurrentIdAndRoleUser();
    // retrieve the group that can edit the post
    $allowedGroup = self::PERMISSIONS["post"]["create"];
    $isInAllowedGroup = in_array($user->role, $allowedGroup);
    // redirect if user role is not in ["admin", "author", "subscriber"]
    if (!$isInAllowedGroup) {
      self::redirectToNotAuthorized();
    }
    return true;
  }

  public static function canDeletePost($entity)
  {
    $user = self::getCurrentIdAndRoleUser();
    // retrieve the group that can edit the post
    $allowedGruop = self::PERMISSIONS["post"]["delete"];
    $isInAllowedGroup = in_array($user->role, $allowedGruop);
    // check if the user is the owner of the post
    $isOwner = $user->id === $entity->user_id;
    // redirect if user role is not in ["admin", "author"]
    // AND if user is not the owner of the post
    if (!$isInAllowedGroup && !$isOwner) {
      self::redirectToNotAuthorized();
    }
    return true;
  }

  public static function redirectToNotAuthorized()
  {
    header("Location: /blog/not-authorized");
    exit;
  }
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

  static function canEditComment($entity)
  {
    $user = self::getCurrentIdAndRoleUser();
    // retrieve the group that can edit the comments
    $allowedGroup = self::PERMISSIONS["comment"]["edit"];
    // check if the user is the owner of the post
    $isInAllowedGroup = in_array($user->role, $allowedGroup);
    // check if the current user is the owner
    $isOwner = $user->id === $entity->user_id;
    // redirect if user role is not in ["admin"]
    // AND if user is not the owner of the comment
    if (!$isInAllowedGroup && !$isOwner) {
      self::redirectToNotAuthorized();
    }
    return true;
  }

  public static function canDeleteComment($entity)
  {
    $user = self::getCurrentIdAndRoleUser();
    // retrieve the group that can edit the comments
    $allowedGroup = self::PERMISSIONS["comment"]["delete"];
    $isInAllowedGroup = in_array($user->role, $allowedGroup);
    // check if the user is the owner of the comment
    $isOwner = $entity->user_id === $user->id;
    // redirect if user role is not in ["admin"]
    // AND if user is not the owner of the comment
    if (!$isInAllowedGroup && !$isOwner) {
      self::redirectToNotAuthorized();
    }
    return true;
  }

  public static function canCreateComment()
  {
    $user = self::getCurrentIdAndRoleUser();
    // retrieve the group that can edit the comments
    $allowedGroup = self::PERMISSIONS["comment"]["create"];
    $isInAllowedGroup = in_array($user->role, $allowedGroup);
    // redirect if user role is not in ["admin", "author", "subscriber"]
    if (!$isInAllowedGroup) {
      self::redirectToNotAuthorized();
    }
    return true;
  }

  public static function canChangeStatusComment($entity)
  {
    $user = self::getCurrentIdAndRoleUser();
    // retrieve the group that can edit the comments
    $allowedGroup = self::PERMISSIONS["comment"]["change-status"];
    $isInAllowedGroup = in_array($user->role, $allowedGroup);
    // check if the user is the owner of the comment
    $isOwner = $user->id === $entity->user_id;
    // redirect if user role is not in ["admin", "author", "subscriber"]
    // AND if user is not the owner of the comment
    if (!$isInAllowedGroup && !$isOwner) {
      self::redirectToNotAuthorized();
    }
    return true;
  }
}
