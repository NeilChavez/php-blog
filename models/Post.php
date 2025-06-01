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
}
