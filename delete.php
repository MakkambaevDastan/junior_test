<?php

use Das\App\Repository\DB;
use Das\App\Repository\UserRepository;

require './vendor/autoload.php';
require 'env.php';

$db = new DB();
$userRepo = new UserRepository($db);
if (empty($_POST['iduser'])) {
    header("Status: 404 Not Found");
} else {
    $userRepo->remove($_POST['iduser']);
}
