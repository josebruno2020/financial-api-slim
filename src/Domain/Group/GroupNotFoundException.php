<?php

namespace App\Domain\Group;

use App\Domain\DomainException\DomainRecordNotFoundException;

class GroupNotFoundException extends DomainRecordNotFoundException
{
    public $message = "Grupo informada não encontrado";
}