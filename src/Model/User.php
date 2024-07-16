<?php

namespace Das\App\Model;

use Lombok\Getter;
use Lombok\Setter;

#[Setter, Getter]
class User extends \Lombok\Helper
{
    protected ?int $id;
    protected string $username;
    protected string $password;
    protected ?Person $person;
    public function __construct(
        string $username,
        string $password,
        ?int $id = null,
        ?Person $person = null
    ) {
        parent::__construct();
        $this->username = $username;
        $this->password = $password;
        $this->id = $id;
        $this->person = $person;
    }
    public function toArray()
    {
        $arr = $this->person->toArray();
        $arr['iduser'] = $this->id;
        $arr['username'] = $this->username;
        return $arr;
    }
}
