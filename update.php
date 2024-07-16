<?php

use Das\App\Model\Person;
use Das\App\Repository\DB;
use Das\App\Repository\PersonRepository;

require './vendor/autoload.php';
require 'env.php';

$db = new DB();
$personRepo = new PersonRepository($db);

$username = $_POST['username'];
$name = $_POST['name'];
$surname = $_POST['surname'];
$birthday = empty($_POST['birthday'])?'2020-01-01':$_POST['birthday'];
$sex =  empty($_POST['sex']) ? 'male':$_POST['sex'];
$iduser = (int)$_POST['iduser'];
$idperson = (int)$_POST['idperson'];

$person = new Person(
    $name,
    $surname,
    $birthday,
    $sex,
    $idperson
);

$personRepo->update($person);

echo json_encode($person->toArray());
