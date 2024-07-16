<?php

use Das\App\Repository\DB;

require './vendor/autoload.php';
require 'env.php';

$db = new DB();
$connect = $db->connect();

$username = $_POST['username'];

$result = $connect->execute_query(
    "SELECT (CASE WHEN COUNT(*) > 0 THEN false ELSE true END) as bool FROM user WHERE username = '$username'"
);
$row = $result->fetch_array();
echo $row['bool'] ? 'true' : 'false';
