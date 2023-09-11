<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Persistence\Balance;

use App\Domain\Balance\Balance;
use App\Domain\Balance\BalanceRepository;
use App\Domain\Enums\MovementTypeEnum;
use App\Domain\User\User;
use Doctrine\ORM\EntityManager;

class DoctrineBalanceRepository implements BalanceRepository
{
    public function __construct(
        private readonly EntityManager $entityManager
    )
    {
    }

    public function getByUserId(int $userId): Balance
    {
        $repo = $this->entityManager->getRepository(Balance::class);
        /** @var Balance $balance */
        $balance = $repo->findOneBy(['user' => $this->entityManager->getReference(User::class, $userId)]);
        if (!$balance) {
            return $this->createBalance($userId);
        }
        return $balance;
    }

    public function createBalance(int $userId): Balance
    {
        $balance = new Balance(
            user: $this->entityManager->getReference(User::class, $userId)
        );
        $this->entityManager->persist($balance);
        $this->entityManager->flush();
        return $balance;
    }

    public function updateUserBalance(int $userId, float $newValue, MovementTypeEnum $type): void
    {
        $balance = $this->getByUserId($userId);
        $currentValue = $balance->getBalance();
        
        if ($type === MovementTypeEnum::INFLOW) {
            $currentValue += $newValue;
        } else {
            $currentValue -= $newValue;
        }
        
        $balance->setBalance($currentValue)
            ->setUpdatedAt();
        $this->entityManager->persist($balance);
        $this->entityManager->flush();
    }

    public function updateUserBalanceOnMovementDelete(int $userId, float $newValue, MovementTypeEnum $type): void
    {
        $balance = $this->getByUserId($userId);
        $currentValue = $balance->getBalance();

        if ($type === MovementTypeEnum::INFLOW) {
            $currentValue -= $newValue;
        } else {
            $currentValue += $newValue;
        }

        $balance->setBalance($currentValue)
            ->setUpdatedAt();
        $this->entityManager->persist($balance);
        $this->entityManager->flush();
    }
}