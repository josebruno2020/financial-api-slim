<?php

namespace App\Domain\Movement;

use App\Domain\DomainException\DomainRecordNotFoundException;

class MovementNotAllowedException extends DomainRecordNotFoundException
{
    public $message = 'Você não tem acesso a esta movimentação.';
}