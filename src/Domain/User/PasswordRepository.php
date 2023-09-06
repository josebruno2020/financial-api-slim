<?php

declare(strict_types=1);

namespace App\Domain\User;

interface PasswordRepository
{
    public function setPassword(string $rawPassword): string;
    
    public function verifyPassword(string $rawPassword, string $password): bool;
}