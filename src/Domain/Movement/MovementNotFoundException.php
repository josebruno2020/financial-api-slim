<?php

namespace App\Domain\Movement;

use App\Domain\DomainException\DomainRecordNotFoundException;

class MovementNotFoundException extends DomainRecordNotFoundException
{
    public $message = 'Movimentação informada não encontrada';
}