<?php

declare(strict_types=1);

namespace App\Infrastructure\Adapters;

use App\Domain\User\PasswordRepository;

class PasswordPhpAdapter implements PasswordRepository
{

    public function setPassword(string $rawPassword): string
    {
        return password_hash($rawPassword, PASSWORD_ARGON2ID);
    }

    public function verifyPassword(string $rawPassword, string $password): bool
    {
        return password_verify($rawPassword, $password);
    }
}