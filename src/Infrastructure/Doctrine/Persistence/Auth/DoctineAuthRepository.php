<?php

namespace App\Infrastructure\Doctrine\Persistence\Auth;

use App\Domain\Auth\AuthRepository;
use App\Domain\User\PasswordRepository;
use App\Domain\User\User;
use App\Domain\User\UserRepository;

class DoctineAuthRepository implements AuthRepository
{
    private PasswordRepository $passwordRepository;
    private UserRepository $userRepository;

    public function __construct(PasswordRepository $passwordRepository, UserRepository $userRepository)
    {
        $this->passwordRepository = $passwordRepository;
        $this->userRepository = $userRepository;
    }

    public function login(string $email, string $password): ?User
    {
        $user = $this->userRepository->findUserByEmail($email);
        
        $auth = $this->passwordRepository->verifyPassword($password, $user->getPassword());
        
        if (!$auth) return null;
        
        return $user;
    }
}