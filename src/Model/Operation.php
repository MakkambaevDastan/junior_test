<?php

namespace Das\App\Model;

enum Operation: string
{
    case CREATE='CREATE';
    case READ ='READ';
    case UPDATE='UPDATE';
    case DELETE='DELETE';
}
