<?php

namespace controller;

use model\Post;
use MVC\Router;
use model\Comment;

class CommentController
{
  static function create(Router $router)
  {
    $comment = new Comment();
    $errors = [];
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $comment = new Comment($_POST);
      $post_id = $comment->post_id;
      //retreive the post
      $errors = array_merge($errors, $comment->validate());
      if (empty($errors)) {
        // save the comment
        $comment->save();
        header("Location: /post?id=" . $post_id . "&message=comment-correctly-inserted");
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
    if($_SERVER["REQUEST_METHOD"] === "POST"){
      $targetComment->sincronize($_POST);
      $targetComment->updated_at = $targetComment->now();
      $errors = $targetComment->validate();
      if(empty($errors)){
        $targetComment->save();
        header("location: /post?id=".$id."&message=comment-updated-successfully#". $targetComment->id);
        exit;
      }
    }

    $router->render("post", [
      "post" => $post,
      "targetComment" => $targetComment,
      "action" => "update"
    ]);
  }
  static function delete()
  {
     if ($_SERVER["REQUEST_METHOD"] === "POST") {
       $commentId = $_POST["comment_id"];
      $postId = $_POST["post_id"];
       $comment = Comment::find($commentId);
       if($comment){
        $res = $comment->delete();
        if($res){
          header("Location: /post?id=" . $postId. "&message=comment-deleted-successfully");
          exit;
        }
       }
     }
  }
}
