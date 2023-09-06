<?php

declare(strict_types=1);

namespace App\Application\Actions\Auth;

use App\Application\Actions\Action;
use App\Domain\Auth\AuthRepository;
use App\Domain\Auth\TokenRepository;
use App\Domain\User\UserRepository;
use Psr\Log\LoggerInterface;

abstract class AuthAction extends Action
{
    protected AuthRepository $authRepository;
    protected TokenRepository $tokenRepository;
    protected UserRepository $userRepository;

    public function __construct(LoggerInterface $logger,
                                AuthRepository  $authRepository,
                                TokenRepository $tokenRepository,
                                UserRepository  $userRepository
    )
    {
        parent::__construct($logger);
        $this->logger = $logger;
        $this->authRepository = $authRepository;
        $this->tokenRepository = $tokenRepository;
        $this->userRepository = $userRepository;
    }
}