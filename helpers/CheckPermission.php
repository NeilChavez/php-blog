<?php

namespace helper;

use model\User;

class CheckPermission
{
  const PERMISSIONS = [
    "post" => [
      "create" => [
        "roles"  => ["admin", "author"]
      ],
      "edit" => [
        "roles" => ["admin", "author"],
        "owner-is-required" => true
      ],
      "delete" => [
        "roles" => ["admin", "author"],
        "owner-is-required" => true
      ]
    ],
    "comment" => [
      "create" => [
        "roles" => ["admin", "author", "subscriber"]
      ],
      "edit" => [
        "roles" => ["admin", "author", "subscriber"],
        "owner-is-required" => true
      ], // and the owner
      "delete" => [
        "roles" => ["admin"]
      ], // and owner
      "change-status" => [
        "roles" => ["admin"],
        "owner-is-required" => true
      ] // and owner
    ]
  ];

  public static function canDoAction($action, $entityType, $entity = null)
  {
    $user = self::getCurrentIdAndRoleUser();
    $rules = self::PERMISSIONS[$entityType][$action];
    // retrieve the group that can edit the entity
    $allowedGroup = $rules["roles"];
    // check if the role is in the allowed role group
    $isInAllowedGroup = in_array($user->role, $allowedGroup);
    // check if user is admin
    $isAdmin = $user->role === "admin";
    // check if the user is the owner of the entity
    $isOwner = $user->id === $entity?->user_id;

    $ownershipRequired = $rules["owner-is-required"] ?? null;

    // give the permission always if user is Admin
    if ($isAdmin) {
      return true;
    }
    // check if the ownership is required for this action
    if ($ownershipRequired) {
      // redirect if the user is NOT the owner 
      if (!$isOwner) {
        self::redirectToNotAuthorized();
      }
      return true;
    }
    // redirect if the user is NOT in the allowed group
    if (!$isInAllowedGroup) {
      self::redirectToNotAuthorized();
    }
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
}
