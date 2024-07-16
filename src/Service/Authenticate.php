<?php

namespace Das\App\Service;
use Das\App\Repository\DB;
use Das\App\Repository\UserRepository;
use Exception;

class Authenticate
{
    public static function login(string $username, string $password)
    {
        if ($username != null && $password != null) {
            $username = strtolower(trim($username));
            $password = md5(trim($password));
        } else {
            return 'Username or password is null';
        }
        if (!preg_match('/^(?!.*\.\.)(?!.*\.$)[^\W][\w.]{0,29}$/', $username)) {
            return 'Username is not correct';
        }

        $db = new DB();
        $connect = $db->connect();

        $result = $connect->execute_query('SELECT iduser FROM user WHERE username=? AND password=?', [$username, $password]);
        $row = $result->fetch_array();
        if(!$row){
            return 'Username or password is incorrect';
        }
        $iduser = $row['iduser'];
        $userRepo = new UserRepository($db);
        return $userRepo->findById($iduser);
    }
}
