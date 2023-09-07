<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Fixtures;

use App\Domain\User\PasswordRepository;
use App\Domain\User\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UserLoader implements FixtureInterface
{
    public function __construct(
        private readonly PasswordRepository $passwordRepository
    )
    {
    }

    public function load(ObjectManager $manager)
    {
        $user = new User(
            email: 'bruno@teste.com',
            name: 'José Bruno',
            password: $this->passwordRepository->setPassword('abc123')
        );
        
        $manager->persist($user);
        $manager->flush();
    }
}