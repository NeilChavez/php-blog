<?php

namespace model;

use model\ActiveRecord\ActiveRecord;

class Category extends ActiveRecord
{
  public $id;
  public $name;
  public $description;
  static $table = "categories";
  static $errors = [];
  static $columns = ["id", "name", "description"];

  function __construct($args = [])
  {
    $this->id = $args["id"] ?? "";
    $this->name = $args["name"] ?? "";
    $this->description = $args["description"] ?? "";
  }

  function validate(){
    if (!trim($this->name)) {
      self::$errors[] = "You need to write a name for the category";
      echo "erro name";
    }
    if (!trim($this->description)) {
      self::$errors[] = "You need to write a description for the category";
      echo "erro description";
    }
    return self::$errors;
  }
}
