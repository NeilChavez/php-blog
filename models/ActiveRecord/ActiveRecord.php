<?php

namespace model\ActiveRecord;

use ErrorException;
use Exception;

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
  function create(): array|Exception|Number
  {
    $keys = implode(", ", array_keys($this->getKeysAndValues()));
    $values = implode("', '", array_values($this->getKeysAndValues()));
    $query = "INSERT INTO " . static::$table . " 
    (" . $keys . ") 
    VALUES
    ('" . $values . "');";
    $res = self::$db->query($query);
    $lastId = self::$db->query("SELECT LAST_INSERT_ID()");
    if (!$res) {
      throw new ErrorException("Query not successfull");
    }
    return $lastId->fetch_assoc();
  }

  //read
  static function getAll($options = []): array
  {
    $query = "SELECT * FROM " . static::$table;
    if (count($options) > 0) {
      $query .= isset($options["where"]) ? " WHERE " . $options["where"] : "";
      $query .= isset($options["order"]) ? " ORDER BY " . $options["order"] : "";
      $query .= isset($options["limit"]) ? " LIMIT " . $options["limit"] :  "";
    }
    $query .= ";";
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

  function save(): bool|array|Exception
  {
    if (!$this->id) {
      return $this->create();
    } else {
      return $this->update($this->id);
    }
  }

  static function findBy($args = []): array|bool
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
    $res = $res->fetch_all(MYSQLI_ASSOC);
    if (!$res) {
      return false;
    }
    $entities = [];
    foreach ($res as $results) {

      $entities[] = self::createObject($results);
    }

    return $entities;
  }

  static function where($key, $value)
  {
    $key = self::sanitizeValue($key);
    $value = self::sanitizeValue($value);
    $query = "SELECT * FROM " . static::$table . " WHERE " . $key . " = '" . $value . "';";
    $res = self::$db->query($query)->fetch_all(MYSQLI_ASSOC);
    $results = [];
    foreach ($res as $row) {
      $results[] = self::createObject($row);
    }
    return $results;
  }

  static function consultSQL($query)
  {
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

  static function count()
  {
    $query = "SELECT COUNT(id) as " . static::$table . " FROM " . static::$table;
    $res = self::$db->query($query)->fetch_all(MYSQLI_ASSOC);
    return array_shift($res);
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

  public function setUpdateTime()
  {
    $this->updated_at = self::now();
  }
}
