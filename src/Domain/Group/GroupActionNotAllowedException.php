<?php

namespace App\Domain\Group;

use App\Domain\DomainException\DomainException;

class GroupActionNotAllowedException extends DomainException
{
    public $message = "Ação não permitida para o grupo informado.";
}