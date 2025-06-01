
<?php

function getConnection()
{
  try {
    $connection = new mysqli(HOST, USER, PASS, DB_NAME);
    return $connection;
  } catch (\Exception $e) {
    throw new \Exception("Database error: " .  $e->getMessage());
  }
}
