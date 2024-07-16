<?php

namespace Das\App\Model;

use Lombok\Getter;
use Lombok\Setter;
use DateTime;

#[Setter, Getter]
class Person  extends \Lombok\Helper
{
    protected ?int $id;
    protected string $name;
    protected string  $surname;
    protected ?string $birthday;
    protected ?string $sex;
    public function __construct(
        string $name,
        string $surname,
        ?string $birthday = null,
        ?string $sex = null,
        ?int $id = null
    ) {
        parent::__construct();
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->birthday = $birthday;
        $this->sex = $sex;
    }
    public function toArray()
    {
        $arr['idperson'] = $this->id;
        $arr['name'] = $this->name;
        $arr['surname'] = $this->surname;
        $arr['birthday'] = $this->birthday;
        $arr['sex'] = $this->sex;
        return $arr;
    }
}
