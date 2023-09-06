<?php

namespace App\Domain\Auth;

use App\Domain\User\User;

interface AuthRepository
{
    public function login(string $email, string $password): ?User;
}