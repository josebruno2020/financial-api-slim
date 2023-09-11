<?php

declare(strict_types=1);

use App\Domain\Auth\AuthRepository;
use App\Domain\Balance\BalanceRepository;
use App\Domain\Category\CategoryRepository;
use App\Domain\Group\GroupRepository;
use App\Domain\Movement\MovementGroupRepository;
use App\Domain\Movement\MovementRepository;
use App\Domain\PaymentForm\PaymentFormRepository;
use App\Infrastructure\Doctrine\Persistence\Auth\DoctineAuthRepository;
use App\Infrastructure\Doctrine\Persistence\Balance\DoctrineBalanceRepository;
use App\Infrastructure\Doctrine\Persistence\Category\DoctrineCategoryRepository;
use App\Infrastructure\Doctrine\Persistence\Group\DoctrineGroupRepository;
use App\Infrastructure\Doctrine\Persistence\Movement\DoctineMovementGroupRepository;
use App\Infrastructure\Doctrine\Persistence\Movement\DoctrineMovementRepository;
use App\Infrastructure\Doctrine\Persistence\PaymentForm\DoctrinePaymentFormRepository;
use DI\ContainerBuilder;
use App\Domain\User\UserRepository;
use App\Infrastructure\Doctrine\Persistence\User\DoctrineUserRepository;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        UserRepository::class => \DI\autowire(DoctrineUserRepository::class),
        CategoryRepository::class => \DI\autowire(DoctrineCategoryRepository::class),
        MovementRepository::class => \DI\autowire(DoctrineMovementRepository::class),
        AuthRepository::class => \DI\autowire(DoctineAuthRepository::class),
        BalanceRepository::class => \DI\autowire(DoctrineBalanceRepository::class),
        PaymentFormRepository::class => \DI\autowire(DoctrinePaymentFormRepository::class),
        GroupRepository::class => \DI\autowire(DoctrineGroupRepository::class),
        MovementGroupRepository::class => \DI\autowire(DoctineMovementGroupRepository::class)
    ]);
};
