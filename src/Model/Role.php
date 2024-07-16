<?php

namespace Das\App\Model;

use Lombok\Getter;
use Lombok\Setter;

#[Setter, Getter]
class Role  extends \Lombok\Helper
{
    protected int $id;
    protected string $name;
    public function __construct(int $id, string $name)
    {
        parent::__construct();
        $this->id = $id;
        $this->name = $name;
    }
}
