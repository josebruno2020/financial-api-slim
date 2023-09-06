<?php

namespace App\Domain\Auth;

use App\Domain\DomainException\DomainException;

class AuthUnauthorizedException extends DomainException
{
    public $message = 'User Unauthorized';
}