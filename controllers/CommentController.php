<?php

namespace controller;

use helper\CheckPermission;
use model\User;
use model\Post;
use MVC\Router;
use model\Comment;

class CommentController
{
  static function create(Router $router)
  {
    CheckPermission::canCreateComment();
    $comment = new Comment();
    $errors = [];
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $comment = new Comment($_POST);
      $post_id = $comment->post_id;
      //retreive the post
      $errors = array_merge($errors, $comment->validate());
      if (empty($errors)) {
        //check if the current user can do this action,
        //if not, he will be redirected by CheckPermission class
        //to a "Not Authorized" page
        CheckPermission::canCreateComment();
        // save the comment
        $comment->save();
        header("Location: /post?id=" . $post_id . "&message=comment-correctly-inserted#success-badge");
        exit;
      } else {
        // we need to render the page again, 
        // so we retreive the post to render it again
        $post = Post::find($post_id);
      }
    }
    $router->render("post", [
      "errors" => $errors,
      "post" => $post,
      "action" => "create"
    ]);
  }
  static function update(Router $router)
  {
    $id = $_GET["post_id"];
    $targeteCommentId = $_GET["comment_id"];
    $post = Post::withComments($id);
    $targetComment = array_filter($post->comments, function ($comment) use ($targeteCommentId) {
      return $comment->id === $targeteCommentId;
    });
    $targetComment = array_shift($targetComment);
    // check if the current user can do this action,
    // if not, he will be redirected by CheckPermission class
    // to a "Not Authorized" page
    CheckPermission::canEditComment($targetComment);
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $targetComment->sincronize($_POST);
      $targetComment->updated_at = $targetComment->now();
      $errors = $targetComment->validate();
      if (empty($errors)) {
        $targetComment->save();

        header("Location: /post?id=" . $id . "&message=comment-updated-successfully#" . $targetComment->id);
        exit;
      }
    }

    $router->render("/blog/post", [
      "post" => $post,
      "targetComment" => $targetComment,
      "action" => "update"
    ]);
  }
  static function delete()
  {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $commentId = filter_var($_POST["comment_id"], FILTER_VALIDATE_INT);
      if (!$commentId) {
        header("Location: /error");
      }
      $postId = $_POST["post_id"] ?? null;
      $comment = Comment::find($commentId);
      if ($comment) {
        // check if the current user can do this action,
        // if not, he will be redirected by CheckPermission class
        // to a "Not Authorized" page
        CheckPermission::canDeleteComment($comment);
        $res = $comment->delete();
        if ($res && str_starts_with($_SERVER["REQUEST_URI"], "/dashboard")) {
          header("Location: /dashboard/comments?id=" . $postId . "&message=comment-deleted");
          exit;
        }
        if ($res) {
          header("Location: /post?id=" . $postId . "&message=comment-deleted#success-badge");
          exit;
        }
      }
    }
  }

  static function approve()
  {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $id = filter_var($_POST["comment_id"], FILTER_VALIDATE_INT);
      if (!$id) {
        header("Location: /blog/error");
        exit;
      }
      /**
       * @var Comment $comment
       */
      $comment = Comment::find($id);
      // check if the current user can do this action,
      // if not, he will be redirected by CheckPermission class
      // to a "Not Authorized" page
      CheckPermission::canChangeStatusComment($comment);
      $comment->status = "published";
      $res = $comment->save();
      if ($res) {
        header("Location: /dashboard/comments/to-approve");
        exit;
      }
    }
  }

  static function unapprove()
  {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $id = filter_var($_POST["comment_id"], FILTER_VALIDATE_INT);
      if (!$id) {
        header("Location: /blog/error");
        exit;
      }
      /**
       * @var Comment $comment
       */
      $comment = Comment::find($id);
      // check if the current user can do this action,
      // if not, he will be redirected by CheckPermission class
      // to a "Not Authorized" page
      CheckPermission::canEditComment($comment);
      $comment->status = "draft";
      $res = $comment->save();
      if ($res) {
        header("Location: /dashboard/comments");
        exit;
      }
    }
  }

  static function toApprove(Router $router)
  {
    $isAdmin = $_SESSION["role"] === "admin";
    $criteria = ["status" => "draft"];
    $comments = [];
    if (!$isAdmin) {
      $criteria["user_id"] = $_SESSION["id"];
    }
    $res = Comment::findBy($criteria);
    $comments = $res ? $res : [];
    $router->render("dashboard/comments/all-comments", [
      "comments" => $comments
    ]);
  }
}
