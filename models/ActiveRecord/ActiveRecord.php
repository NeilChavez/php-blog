<?php

namespace model\ActiveRecord;

use ErrorException;

class ActiveRecord
{
  public $id;
  public $updated_at;
  static $db;
  static $table;
  static $columns;

  static function connect($connection)
  {
    self::$db = $connection;
  }
  //create
  function create(): bool|ActiveRecord
  {
    $keys = implode(", ", array_keys($this->getKeysAndValues()));
    $values = implode("', '", array_values($this->getKeysAndValues()));
    $query = "INSERT INTO " . static::$table . " 
    (" . $keys . ") 
    VALUES
    ('" . $values . "');";
    $res = self::$db->query($query);
    if (!$res) {
      throw new ErrorException("Query not successfull");
    }
    return $res;
  }

  //read
  static function getAll(): array
  {
    $res = self::$db->query("SELECT * FROM " . static::$table)->fetch_all(MYSQLI_ASSOC);
    if (!$res) {
      throw new ErrorException("Query not successfull");
    }
    $results = [];
    foreach ($res as $row) {
      $results[] = self::createObject($row);
    }
    return $results;
  }

  // read one
  static function find(int $id): ActiveRecord|bool
  {
    $res = self::$db->query("SELECT * FROM " . static::$table . " WHERE " . static::$table . ".id = " . self::$db->real_escape_string($id) . ";");
    if (!$res) {
      throw new ErrorException("Query not successf0ull");
    }
    $res = $res->fetch_assoc();
    if (!$res) {
      return false;
    }
    $entity = self::createObject($res);
    return $entity;
  }

  //update
  function update(int $id): bool
  {
    $now = $this->now();
    $this->updated_at = $now;
    $keyAndValues = $this->getKeysAndValues();
    $columnsAndValues = [];
    foreach ($keyAndValues as $key => $value) {
      $columnsAndValues[] = "$key = '$value'";
    };
    $query = "UPDATE " . static::$table . " SET ";
    $query .= implode(", ", $columnsAndValues);
    $query .= " WHERE " . static::$table . ".id = '" . $this->sanitizeValue($id) . "' LIMIT 1;";
    $res = self::$db->query($query);
    if (!$res) {
      throw new ErrorException("Query not successf0ull");
    }
    return $res;
  }

  //delete
  function delete(): bool
  {
    $query = "DELETE FROM " . static::$table . " WHERE " . static::$table . ".id = '" . self::sanitizeValue($this->id) . "';";
    $res = self::$db->query($query);
    if (!$res) {
      throw new ErrorException("Delete Query not successfull");
    }
    return $res;
  }

  function save(): ActiveRecord|bool
  {
    if (!$this->id) {
      return $this->create();
    } else {
      return $this->update($this->id);
    }
  }

  static function findBy($args = []): ActiveRecord|bool
  {
    $criteria = "";
    foreach ($args as $key => $value) {
      $value = self::sanitizeValue($value);
      $criteria .= static::$table . "." . $key . " = " . "'$value'";
      //add AND between more criterias
      if (next($args)) {
        $criteria .= " AND ";
      }
    }
    $query = "SELECT * FROM " . static::$table . " WHERE " . $criteria . ";";
    $res = self::$db->query($query);
    if (!$res) {
      throw new ErrorException("Query not successf0ull");
    }
    $res = $res->fetch_assoc();
    if (!$res) {
      return false;
    }
    $entity = self::createObject($res);
    return $entity;
  }

  static function consultSQL($query){
    $res = self::$db->query($query)->fetch_all(MYSQLI_ASSOC);
    if (!$res) {
      throw new ErrorException("Query not successfull");
    }
    $results = [];
    foreach ($res as $row) {
      $results[] = self::createObject($row);
    }
    return $results;
  }

  function sincronize($args = [])
  {
    foreach ($args as $key => $value) {
      if (property_exists($this, $key)) {
        $this->$key = $value;
      }
    }
  }

  static function createObject($entry)
  {
    $entity = new static;
    foreach ($entry as $key => $value) {
      if (property_exists($entity, $key)) {
        $entity->$key = $value;
      }
    }
    return $entity;
  }
  static function now(): string
  {
    return date('Y-m-d H:i:s');
  }

  function getKeysAndValues(): array
  {
    $keysAndValues = [];
    foreach (static::$columns as $attribute) {
      if ($attribute !== "id" && $this->$attribute !== "") {
        $keysAndValues[$attribute] = self::sanitizeValue($this->$attribute);
      }
    }
    return $keysAndValues;
  }

  static function sanitizeValue($value)
  {
    if ($value === null) {
      return null;
    }
    return self::$db->real_escape_string($value);
  }
}
