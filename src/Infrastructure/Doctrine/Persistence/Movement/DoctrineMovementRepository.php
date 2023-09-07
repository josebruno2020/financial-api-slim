<?php

namespace App\Infrastructure\Doctrine\Persistence\Movement;

use App\Domain\Balance\BalanceRepository;
use App\Domain\Category\Category;
use App\Domain\Enums\MovementTypeEnum;
use App\Domain\Movement\Movement;
use App\Domain\Movement\MovementNotFoundException;
use App\Domain\Movement\MovementRepository;
use App\Domain\User\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

readonly class DoctrineMovementRepository implements MovementRepository
{
    public function __construct(
        private EntityManager $entityManager,
        private BalanceRepository $balanceRepository
    )
    {
    }


    private function setRepository(): EntityRepository
    {
        return $this->entityManager->getRepository(Movement::class);
    }

    /**
     * @return Movement[] array
     */
    public function findAllInCurrentMonth(int $userId): array
    {
        $currentMonth = date('Y-m');
        $repo = $this->setRepository();

        return $repo->createQueryBuilder('m')
            ->where('m.date LIKE :month')
            ->andWhere('m.user = :user')
            ->setParameter('month', "$currentMonth%")
            ->setParameter('user', $userId)
            ->getQuery()->getResult();
    }

    /**
     * @return Movement[] array
     */
    public function findAll(int $userId): array
    {
        $repo = $this->setRepository();
        return $repo->findBy(['user' => $userId]);
    }

    /**
     * @param array{user_id: int, category_id: int, value: float, date: ?string, type: int, userId: int, obs: ?string} $data
     * @return Movement
     */
    public function createMovement(array $data): Movement
    {
        $movement = new Movement(
            category: $this->entityManager->getReference(Category::class, $data['category_id']),
            type: $data['type'],
            value: $data['value'],
            date: $data['date'] ?? null,
            user: $this->entityManager->getReference(User::class, $data['userId']),
            obs: $data['obs'] ?? null
        );
        $this->entityManager->persist($movement);
        $this->entityManager->flush();


        $this->balanceRepository->updateUserBalance(
            userId:  $data['userId'],
            newValue: $data['value'],
            type: MovementTypeEnum::make($data['type'])
        );
        return $movement;
    }

    public function deleteMovementById(int $id, int $userId): void
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

    /**
     * @return array<string, float>
     */
    public function findTotalByTypeAndCategoryInMonth(string $month, MovementTypeEnum $type, int $userId): array
    {
        $repo = $this->setRepository();
        $q = $repo->createQueryBuilder('m');
        return $q->select('sum(m.value) as total, c.name')
                ->join('m.category', 'c')
                ->where('m.date LIKE :month')
                ->andWhere('m.type = :type')
                ->andWhere('m.user = :user_id')
                ->setParameter('month', "$month%")
                ->setParameter('type', $type->value)
                ->setParameter('user_id', $userId)
                ->groupBy('c.id')
                ->orderBy('sum(m.value)', 'desc')
                ->getQuery()
                ->getResult();
    }
}