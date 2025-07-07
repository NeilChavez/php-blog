<?php

namespace model;

use model\ActiveRecord\ActiveRecord;

class Comment extends ActiveRecord
{
  public $id;
  public $content;
  public $status;
  public $created_at;
  public $updated_at;
  public $post_id;
  public $user_id;
  public $username;
  static $table = "comments";
  static $errors = [];
  static $columns = ["id", "content", "status", "created_at", "updated_at", "post_id", "user_id"];

  function __construct($args = [])
  {
    $this->id = $args["id"] ?? "";
    $this->content = $args["content"] ?? "";
    $this->status = "draft" ?? ""; //draft by deafult
    $this->created_at = self::now() ?? "";
    $this->updated_at = self::now() ?? "";
    $this->post_id = $args["post_id"] ?? "";
    $this->user_id = $args["user_id"] ?? "";
    $this->username = $args["username"] ?? "";
  }

  function validate()
  {
    if (!$this->content) {
      self::$errors[] = "The comment needs a content";
    }
    return self::$errors;
  }

  static function commentsByPost($id)
  {
    $query = "SELECT 
    	c.content, c.post_id, c.user_id, u.username
    FROM 
    	comments c
    INNER JOIN
    	users u
    ON 
    	c.user_id = u.id
    WHERE 
    	c.post_id = " . self::sanitizeValue($id) . ";";

    $res = self::consultSQL($query);
    return $res;
  }
}
