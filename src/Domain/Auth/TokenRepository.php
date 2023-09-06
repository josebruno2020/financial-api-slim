<?php

namespace App\Domain\Auth;

use App\Domain\User\User;

interface TokenRepository
{
    public function encodeToken(User $user, int $daysToExpire = 10): string;
    
    /**
     * @throws InvalidTokenException
     */
    public function decodeToken(string $token): array;
}