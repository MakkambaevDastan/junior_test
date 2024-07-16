<?php

use Das\App\Model\Person;
use Das\App\Model\User;
use Das\App\Repository\DB;
use Das\App\Repository\UserRepository;

require './vendor/autoload.php';
require 'env.php';

$db = new DB();
$userRepo = new UserRepository($db);

$username = strtolower(trim($_POST['username']));
$password = md5(trim($_POST['password']));

$user = new User($username, $password, null, new Person($username, $username));

$userRepo->add($user);

echo json_encode($user->toArray());
