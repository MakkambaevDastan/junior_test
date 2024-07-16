<?php
require './vendor/autoload.php';
session_start();
if (empty($_SESSION['user'])) {
  header('Location: /login.php');
} else {
  header('Location: /admin.php');
}
