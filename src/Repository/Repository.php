<?php

namespace Das\App\Repository;

interface Repository
{
    public function add($object);
    public function findAll();
    public function findById(int $id);
    public function getPage(?int $page=1, ?int $size=10, ?string $sort=null, ?string $asc='asc');
    public function update($object);
    public function remove($object);
}