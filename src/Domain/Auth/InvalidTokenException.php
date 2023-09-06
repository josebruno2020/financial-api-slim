<?php

namespace App\Domain\Auth;

use App\Domain\DomainException\DomainException;

class InvalidTokenException extends DomainException
{
    public $message = 'Token inválido ou expirado';
}