<?php

declare(strict_types=1);

use App\Domain\Auth\AuthRepository;
use App\Domain\Category\CategoryRepository;
use App\Domain\Movement\MovementRepository;
use App\Infrastructure\Doctrine\Persistence\Auth\DoctineAuthRepository;
use App\Infrastructure\Doctrine\Persistence\Category\DoctrineCategoryRepository;
use App\Infrastructure\Doctrine\Persistence\Movement\DoctrineMovementRepository;
use DI\ContainerBuilder;
use App\Domain\User\UserRepository;
use App\Infrastructure\Doctrine\Persistence\User\DoctrineUserRepository;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our UserRepository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        UserRepository::class => \DI\autowire(DoctrineUserRepository::class),
        CategoryRepository::class => \DI\autowire(DoctrineCategoryRepository::class),
        MovementRepository::class => \DI\autowire(DoctrineMovementRepository::class),
        AuthRepository::class => \DI\autowire(DoctineAuthRepository::class),
    ]);
};
