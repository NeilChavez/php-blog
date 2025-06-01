<?php 
require "../vendor/autoload.php";
require "../constants.php";
require "../config/db/db.php";

use model\ActiveRecord\ActiveRecord;

$connection = getConnection();
ActiveRecord::connect($connection);