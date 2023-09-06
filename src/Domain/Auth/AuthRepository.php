<?php

namespace App\Domain\Auth;

interface AuthRepository
{
    public function login(string $email, string $password): bool;
}