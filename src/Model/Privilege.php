<?php

namespace Das\App\Model;

use Lombok\Getter;
use Lombok\Setter;

#[Setter, Getter]
class Privilege  extends \Lombok\Helper
{
    protected int $id;
    protected int $id_role;
    protected string $object;
    protected Operation $operation;
    public function __construct(
        int $id,
        int $id_role,
        string $object,
        Operation $operation
    ) {
        $this->id = $id;
        $this->id_role = $id_role;
        $this->object = $object;
        $this->operation = $operation;
    }
}
