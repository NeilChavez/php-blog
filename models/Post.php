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
  public $categories;

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
    $this->updated_at = self::now() ?? "";
    $this->user_id = $args["user_id"] ?? "";
    $this->categories = $args["categories"] ?? null;

  }

  function categoriesFiltered(){
    $arr = $this->categories;
    $filtered = array_filter($arr, function ($value) {
      return !empty($value);
    });
    $this->categories = $filtered;
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
    $this->categoriesFiltered();
    if (empty($this->categories)) {
      self::$errors[] = "You need to choose at least one category";
    }
    return self::$errors;
  }

  function savePost(): void
  {
    $this->slug = $this->generateSlug($this->title);
    @session_start();
    $this->user_id = $_SESSION["id"];
    $isEditing = $this->id;
    $idPost = "";
    if ($isEditing) {
      $idPost = (int) $this->id;
      $this->save();
    } else {
      $lastIdInserted = $this->save();
      $idPost = (int) $lastIdInserted["LAST_INSERT_ID()"];
    }
    $res = $this->saveCategories($idPost);
    if (!empty($res)) {
      $state = $isEditing ? "updated" : "created";
      header("Location: /dashboard/posts?message=" . $state . "-with-success");
      exit;
    }
  }

  public function saveCategories(int $post_id)
  {
    self::deleteCategories($post_id);
    $values = "(" . $post_id . ", ";
    $separator = "), (" . self::sanitizeValue($post_id) . ", ";
    $values .= implode($separator, $this->categories);
    $values .= ")";
   
    $res = "";

    $query = "INSERT INTO categories_has_posts (post_id, category_id) VALUES " . $values . ";";
    $res = self::$db->query($query);
    return $res;
  }

  static function deleteCategories(int $post_id)
  {
    $query = "DELETE FROM categories_has_posts WHERE post_id = " . self::sanitizeValue($post_id) . ";";

    $res = self::$db->query($query);
    return $res;
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
      $this->deleteCategoriesAssociation($this->id);
      header("Location: /dashboard/posts?message=deleted-with-success");
      exit;
    }
  }

  function deleteCategoriesAssociation(int $id){
    $query = "DELETE FROM categories_has_posts WHERE post_id = " . self::sanitizeValue($id);
    self::consultSQL($query);
  }

  static function withComments(int $id): Post
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
        "commentId" => $id,
        "comment" => $content,
        "commentAuthor" => $username,
        "commentUserId" => $user_id,
        "id" => $post_id
      ] = $entity;
      if ($content && $username && $id && $user_id) {
        $comments[] = new Comment([
          "id" => $id,
          "content" => $content,
          "username" => $username,
          "user_id" => $user_id,
          "post_id" => $post_id
        ]);
      }
    }
    $post->comments = $comments;
    return $post;
  }

  static function withCategories(int $id): Post
  {
    /**
     * @var Post $post
     */
    $post = Post::find($id);
    $post->categories = self::fetchCategoriesPost($id);
    return $post;
  }

  static function fetchCategoriesPost(int $id): array
  {
    $categories = [];
    $query = "SELECT category_id FROM categories_has_posts WHERE post_id = " . self::sanitizeValue($id) . ";";
    $res = self::$db->query($query);
    while ($row = $res->fetch_assoc()) {
      $categories[] = $row["category_id"];
    }
    return $categories;
  }

  static function findByCategory($category)
  {
    $query = "SELECT * FROM categories_has_posts WHERE category_id = " . self::sanitizeValue($category) . ";";
    $results = self::$db->query($query);
    $results = $results->fetch_all(MYSQLI_ASSOC);
    $ids = [];
    foreach ($results as $result) {
      $ids[] = $result["post_id"];
    }

    $ids = implode(", ", $ids);
    $query = "SELECT * FROM posts WHERE id IN (" . $ids . ");";
    $posts = self::consultSQL($query);
    return $posts;
  }
}
