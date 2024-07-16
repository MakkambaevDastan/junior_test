<?php

namespace Das\App\Repository;

use Das\App\Model\Person;
use Das\App\Model\Sex;

class PersonRepository implements Repository
{
    private  DB $db;
    private $connect;
    public function __construct(DB $db)
    {
        $this->db = $db;
        $this->connect = $this->db->connect();
    }
    public function add($person)
    {
        $this->connect->execute_query(
            "INSERT INTO person (name, surname, birthday, sex) VALUES(?,?,?,?)",
            [
                $person->getName(),
                $person->getSurname(),
                $person->getBirthday(),
                $person->getSex()
            ]
        );
        $result= $this->connect->execute_query("SELECT idperson FROM person WHERE idperson = LAST_INSERT_ID()");
        $row = $result->fetch_array();
        $person->setId((int)$row['idperson']);
    }
    public function findAll()
    {
    }
    public function findById(int $id)
    {
        $result = $this->connect->execute_query(
            "SELECT idperson, name, surname, birthday, sex FROM person WHERE idperson=?",
            [$id]
        );
        $row = $result->fetch_array();
        return new Person(
            $row['name'],
            $row['surname'],
            $row['birthday'],
            $row['sex'],
            (int)$row['idperson']
        );
    }
    public function getPage(?int $page=1, ?int $size=10, ?string $sort=null, ?string $asc='asc')
    {
    }
    public function update($person)
    {
        $person->getSex();
        $this->connect->execute_query(
            "UPDATE person SET name=?, surname=?, birthday=?, sex=? WHERE idperson= ?",
            [
                $person->getName(),
                $person->getSurname(),
                $person->getBirthday(),
                $person->getSex(),
                $person->getId()
            ]
        );
    }
    public function remove($person)
    {
        $this->connect->execute_query(
            "DELETE FROM person WHERE idperson=?",[$person->getId()]
        );
    }
}
