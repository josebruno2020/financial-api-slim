<?php

declare(strict_types=1);

namespace App\Application\Actions\Auth;

use App\Domain\Auth\AuthUnauthorizedException;
use Psr\Http\Message\ResponseInterface as Response;

class LoginAction extends AuthAction
{
    
    protected function action(): Response
    {
        $body = $this->getBody();
        $user = $this->authRepository->login(email: $body['email'], password: $body['password']);
        
        if (!$user) {
            throw new AuthUnauthorizedException();
        }
        
        $token = $this->tokenRepository->encodeToken($user);
        
        return $this->respondWithData(compact('token', 'user'));
    }
}