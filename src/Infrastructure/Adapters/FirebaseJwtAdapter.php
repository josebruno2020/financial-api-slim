<?php

namespace App\Infrastructure\Adapters;

use App\Domain\Auth\InvalidTokenException;
use App\Domain\Auth\TokenRepository;
use App\Domain\User\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class FirebaseJwtAdapter implements TokenRepository
{
    private string $key;
    private string $algo = 'HS256';

    public function __construct()
    {
        $this->key = $_ENV['JWT_KEY'];
    }

    public function encodeToken(User $user, int $daysToExpire = 10): string
    {
        $tokenInfo = [
            'iat' => time(),
            'exp' => time() + 60 * 60 * 24 * $daysToExpire,
        ];
        $payload = [...$tokenInfo, ...$user->jsonSerialize()];
        return JWT::encode($payload, $this->key, $this->algo);
    }

    /**
     * @throws InvalidTokenException
     */
    public function decodeToken(string $token): array
    {
        try {
            return (array) JWT::decode($token, new Key($this->key, $this->algo));
        } catch (\Exception $e) {
            throw new InvalidTokenException();  
        }       
    }
}