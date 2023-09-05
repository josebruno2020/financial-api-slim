<?php

namespace App\Infrastructure\Doctrine\Persistence\Movement;

use App\Domain\Category\Category;
use App\Domain\Enums\MovementTypeEnum;
use App\Domain\Movement\Movement;
use App\Domain\Movement\MovementNotFoundException;
use App\Domain\Movement\MovementRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class DoctrineMovementRepository implements MovementRepository
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    private function setRepository(): EntityRepository
    {
        return $this->entityManager->getRepository(Movement::class);
    }

    /**
     * @return Movement[] array
     */
    public function findAllInCurrentMonth(): array
    {
        $currentMonth = date('Y-m');
        $repo = $this->setRepository();

        return $repo->createQueryBuilder('m')
            ->where('m.date LIKE :month')
            ->setParameter('month', "$currentMonth%")
            ->getQuery()->getResult();
    }

    /**
     * @return Movement[] array
     */
    public function findAll(): array
    {
        $repo = $this->setRepository();
        return $repo->findAll();
    }

    /**
     * @param array{user_id: int, category_id: int, value: float, date: ?string, type: int, obs: ?string} $data
     * @return Movement
     */
    public function createMovement(array $data): Movement
    {
        $movement = new Movement(
            category: $this->entityManager->getReference(Category::class, $data['category_id']),
            type: $data['type'],
            value: $data['value'],
            date: $data['date'] ?? null,
            obs: $data['obs'] ?? null
        );
        $this->entityManager->persist($movement);
        $this->entityManager->flush();

        return $movement;
    }

    public function deleteMovementById(int $id): void
    {
        $movement = $this->findMovementById($id);
        $this->entityManager->remove($movement);
        $this->entityManager->flush();
    }

    public function findMovementById(int $id): ?Movement
    {
        $repo = $this->setRepository();
        $movement = $repo->find($id);
        if (!$movement) {
            throw new MovementNotFoundException();
        }

        /**
         * @var Movement $movement
         */
        return $movement;
    }
}