
<?php

function getConnection()
{
  try {
    $connection = new mysqli(BD_HOST, DB_USER, DB_PASS, DB_NAME);
    return $connection;
  } catch (\Exception $e) {
    throw new \Exception("Database error: " .  $e->getMessage());
  }
}
