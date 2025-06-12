<?php

namespace model;

use model\ActiveRecord\ActiveRecord;

class Post extends ActiveRecord
{
  public $id;
  public $title;
  public $slug;
  public $featured_image;
  public $content;
  public $status;
  public $created_at;
  public $updated_at;
  public $user_id;
  public $comments = [];

  static $table = "posts";
  static $columns = ["id", "title", "slug", "featured_image", "content", "status", "created_at", "updated_at", "user_id"];
  static $errors = [];
  function __construct($args = [])
  {
    $this->id = $args["id"] ?? null;
    $this->title = isset($args["title"]) ? trim($args["title"]) : "";
    $this->slug = $args["slug"] ?? "";
    $this->featured_image = $args["featured_image"] ?? null;
    $this->content = isset($args["content"]) ? trim($args["content"]) : "";
    $this->status = $args["status"] ?? "";
    $this->created_at = self::now() ?? "";
    $this->updated_at = $args["updated_at"] ?? "";
    $this->user_id = $args["user_id"] ?? "";
  }

  function generateSlug($title): string
  {
    $table = array(
      '/' => '-',
      ' ' => '-',
      "'" => '',
      ':' => '',
      'Ç' => 'C',
      'È' => 'E',
      'É' => 'E',
      'Ê' => 'E',
      'Ñ' => 'N',
      'ç' => 'c',
      'è' => 'e',
      'é' => 'e',
      'ñ' => 'n'
    );
    //remove duplicated spaces
    $slug = trim($title);
    $slug = strtr($title, $table);
    $slug = trim($slug, '-');
    //returns the slug
    return strtolower($slug);
  }

  function isEmptyString($text): bool
  {
    return $text === null || "" === trim($text);
  }

  function validate(): array
  {
    if ($this->isEmptyString($this->title)) {
      self::$errors[] = "You need to write a title";
    }
    if ($this->isEmptyString($this->content)) {
      self::$errors[] = "You need to write a content for the post";
    }
    if (!$this->status) {
      self::$errors[] = "You need to choose a status";
    }
    if (!$this->featured_image) {
      self::$errors[] = "You need to upload an image";
    }
    return self::$errors;
  }

  function savePost(): void
  {
    $this->slug = $this->generateSlug($this->title);
    $this->user_id = 1; //TODO take the actual user
    $res = $this->save();
    if ($res) {
      $state = $this->id ? "updated" : "created";
      header("Location: /home?message=" . $state . "-with-success");
      exit;
    }
  }
  function setImage($imageName)
  {
    $this->featured_image = $imageName;
  }

  function removeImage()
  {
    $imagesPath =  $_SERVER["DOCUMENT_ROOT"] . "/src/images/";
    if (is_file($imagesPath . $this->featured_image)) {
      unlink($imagesPath . $this->featured_image);
    }
  }

  function deletePost()
  {
    $res = $this->delete();
    if ($res) {
      $this->removeImage();
      header("Location: /home?message=deleted-with-success");
      exit;
    }
  }
  static function withComments($id)
  {
    $query = " SELECT 
     p.id, u.username as postAuthor, p.title, p.slug, p.featured_image, p.content, p.status, p.created_at, p.updated_at, c.id as commentId, c.content as comment, us.username as commentAuthor, us.id as commentUserId
    FROM 
      posts p
    LEFT JOIN 
      comments c
    ON p.id = c.post_id
    LEFT JOIN
      users u
    ON p.user_id = u.id
    LEFT JOIN
      users us
    ON c.user_id = us.id
    WHERE p.id = " . self::sanitizeValue($id) . ";";
    $res =  self::$db->query($query);
    $res = $res->fetch_all(MYSQLI_ASSOC);
    $postWithComments = $res;
    // we take the first row of the results, since we have more rows with the same post information but with the different comment information
    $post = array_shift($res);
    /**
     * @var Post $post
     */
    $post = new self($post);
    $comments = [];
    foreach ($postWithComments as $entity) {
      [
        "comment" => $content,
        "commentAuthor" => $username,
        "commentId" => $id,
        "commentUserId" => $user_id
      ] = $entity;
      $comments[] = new Comment([
        "id" => $id,
        "content" => $content,
        "username" => $username,
        "user_id" => $user_id
      ]);
    }
    $post->comments = $comments;
    return $post;
  }
}
