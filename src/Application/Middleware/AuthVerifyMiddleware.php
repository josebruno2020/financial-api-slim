<?php

namespace App\Application\Middleware;

use App\Domain\Auth\InvalidTokenException;
use App\Domain\Auth\TokenRepository;
use App\Domain\DomainException\DomainInvalidArgumentException;
use App\Domain\Validation\DomainValidationHelper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpUnauthorizedException;

class AuthVerifyMiddleware implements Middleware
{
    private DomainValidationHelper $validationHelper;
    private TokenRepository $tokenRepository;

    public function __construct(DomainValidationHelper $validationHelper, TokenRepository $tokenRepository)
    {
        $this->validationHelper = $validationHelper;
        $this->tokenRepository = $tokenRepository;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $hasHeader = $request->hasHeader('Authorization');

        try {
            if (!$hasHeader) {
                throw new InvalidTokenException();
            }
            $header = $request->getHeader('Authorization')[0];
            $token = explode('Bearer ', $header)[1];
            $user = $this->tokenRepository->decodeToken($token);
            $request = $request->withAttribute('userId', $user['id']);
        } catch (InvalidTokenException $e) {
            throw new HttpUnauthorizedException($request, $e->getMessage());
        }

        return $handler->handle($request);
    }
}