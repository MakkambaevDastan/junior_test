<?php

use Das\App\Service\Authenticate;

require './vendor/autoload.php';
require 'env.php';

session_start();

$user  = Authenticate::login($_POST['username'], $_POST['password']);

if (is_string($user)) {
    $_SESSION['message'] = $user;
    header('Location: /login.php');
} else {
    $_SESSION['user'] = $user;
    header('Location: /admin.php');
}