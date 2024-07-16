<?php

namespace Das\App\Repository;

use Das\App\Model\User;

class UserRepository implements Repository
{
    private DB $db;
    private $connect;
    public function __construct(DB $db)
    {
        $this->db = $db;
        $this->connect = $this->db->connect();
    }
    public function add($user)
    {

        $this->connect->execute_query(
            "INSERT INTO user (username, password) VALUES(?,?)",
            [
                $user->getUsername(),
                $user->getPassword()
            ]
        );
        $result = $this->connect->execute_query("SELECT iduser FROM user WHERE iduser = LAST_INSERT_ID()");
        $row = $result->fetch_array();
        $user->setId($row['iduser']);

        if (!empty($user->getPerson())) {
            $personRepo = new PersonRepository($this->db);
            $personRepo->add($user->getPerson());
            $this->update($user);
        }
    }
    public function findAll()
    {
        $arr = [];
        $result = $this->connect->execute_query(
            "SELECT
                user.iduser,
                user.username,
                user.idperson,
                person.name,
                person.surname,
                person.birthday,
                person.sex
            FROM
                user
                INNER JOIN person ON person.idperson = user.idperson"
        );
        while ($row = $result->fetch_array()) {
            $arr[$row['username']]['username'] = $row['username'];
            $arr[$row['username']]['iduser'] = $row['iduser'];
            $arr[$row['username']]['idperson'] = $row['idperson'];
            $arr[$row['username']]['name'] = $row['name'];
            $arr[$row['username']]['surname'] = $row['surname'];
            $arr[$row['username']]['birthday'] = $row['birthday'];
            $arr[$row['username']]['sex'] = $row['sex'];
        }
        return $arr;
    }
    public function findById(int $id)
    {
        $result = $this->connect->execute_query(
            "SELECT iduser, username, password, idperson FROM user WHERE iduser=?",
            [$id]
        );

        $row = $result->fetch_array();

        $personRepo = new PersonRepository($this->db);

        $person = $personRepo->findById((int)$row['idperson']);

        return new User(
            $row['username'],
            $row['password'],
            (int)$row['iduser'],
            $person
        );
    }
    public function getPage(?int $page = 1, ?int $size = 10, ?string $sort = 'username', ?string $asc = 'asc')

    {
        // if ($asc==1) {
        //     $sc = "ASC";
        // } else {
        //     $sc = "DESC";
        // }
        $offset = ($page - 1) * $size;
        $sql = "SELECT 
            user.iduser, 
            user.username, 
            user.idperson, 
            person.name, 
            person.surname, 
            person.birthday, 
            person.sex
        FROM user INNER JOIN person ON user.idperson=person.idperson
        ORDER BY  $sort $asc LIMIT $size OFFSET $offset";
        $result = $this->connect->execute_query($sql);
        $arr = [];
        $arr['page'] = $page;
        $arr['size'] = $size;
        $arr['sort'] = $sort;
        $arr['asc'] = $asc;
        $arr['count'] = (($this->connect->execute_query("SELECT COUNT(iduser) as count FROM user"))->fetch_array())['count'];
        while ($row = $result->fetch_array()) {
            $arr['list'][$row['username']]['iduser'] = $row['iduser'];
            $arr['list'][$row['username']]['username'] = $row['username'];
            $arr['list'][$row['username']]['idperson'] = $row['idperson'];
            $arr['list'][$row['username']]['name'] = $row['name'];
            $arr['list'][$row['username']]['surname'] = $row['surname'];
            $arr['list'][$row['username']]['birthday'] = $row['birthday'];
            $arr['list'][$row['username']]['sex'] = $row['sex'];
        }
        return $arr;
    }
    public function update($user)
    {
        $this->connect->execute_query(
            "UPDATE user SET  idperson = ? WHERE iduser = ?",
            [
                $user->getPerson()->getId(),
                $user->getId(),
            ]
        );
    }
    public function remove($iduser)
    {
        $this->connect->execute_query(
            "DELETE FROM user WHERE iduser=?",
            [$iduser]
        );
    }
}
