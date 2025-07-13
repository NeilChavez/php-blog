<?php 
require "../vendor/autoload.php";
require "../config/db/db.php";

use model\ActiveRecord\ActiveRecord;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();
// load after Dotenv initialization since we need $_ENV populated to use environment variables in constants.php
require "../constants.php";

$connection = getConnection();
ActiveRecord::connect($connection);
