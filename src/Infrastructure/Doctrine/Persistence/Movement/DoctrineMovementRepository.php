<?php

namespace App\Infrastructure\Doctrine\Persistence\Movement;

use App\Domain\Balance\BalanceRepository;
use App\Domain\Category\Category;
use App\Domain\Enums\MovementTypeEnum;
use App\Domain\Group\Group;
use App\Domain\Movement\Movement;
use App\Domain\Movement\MovementNotFoundException;
use App\Domain\Movement\MovementRepository;
use App\Domain\PaymentForm\PaymentForm;
use App\Domain\User\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Exception\ORMException;

readonly class DoctrineMovementRepository implements MovementRepository
{
    public function __construct(
        private EntityManager     $entityManager,
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
    public function findAllInMonth(int $userId, string $month, ?int $categoryId = null, ?MovementTypeEnum $type = null): array
    {
        $repo = $this->setRepository();
        $q = $repo->createQueryBuilder('m')
            ->where('m.date LIKE :month')
            ->andWhere('m.user = :user')
            ->setParameter('month', "$month%")
            ->setParameter('user', $userId);
        if ($categoryId) {
            $q = $q->andWhere('m.category = :category')
                ->setParameter('category', $categoryId);
        }
        if ($type) {
            $q = $q->andWhere('m.type = :type')
                ->setParameter('type', $type);
        }
        return $q->orderBy('m.date', 'desc')->getQuery()->getResult();
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
     * @param array{user_id: int, category_id: int, value: float, payment_form_id: int, date: ?string, type: int, userId: int, obs: ?string, group_id: ?int} $data
     * @return Movement
     * @throws ORMException
     */
    public function createMovement(array $data): Movement
    {
        $groupReference = null;
        if (isset($data['group_id'])) {
            $groupReference = $this->entityManager->getReference(Group::class, $data['group_id']);
        }
        $movement = new Movement(
            category: $this->entityManager->getReference(Category::class, $data['category_id']),
            type: $data['type'],
            value: $data['value'],
            paymentForm: $this->entityManager->getReference(PaymentForm::class, $data['payment_form_id']),
            date: $data['date'] ?? null,
            user: $this->entityManager->getReference(User::class, $data['userId']),
            obs: $data['obs'] ?? null,
            group: $groupReference
        );
        $this->entityManager->persist($movement);
        $this->entityManager->flush();


        $this->balanceRepository->updateUserBalance(
            userId: $data['userId'],
            newValue: $data['value'],
            type: MovementTypeEnum::make($data['type'])
        );
        return $movement;
    }

    public function deleteMovementById(int $id, int $userId): void
    {
        $movement = $this->findMovementById($id);
        $this->balanceRepository->updateUserBalanceOnMovementDelete(
            userId: $movement->getUser()->getId(),
            newValue: $movement->getValue(),
            type: $movement->getType()
        );
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
        return $q->select('sum(m.value) as total, c.name, c.id')
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

    public function findTotalTypeInMonth(string $month, int $userId): array
    {
        $repo = $this->setRepository();
        $q = $repo->createQueryBuilder('m');
        return $q->select('sum(m.value) as total, m.type')
            ->where('m.date LIKE :month')
            ->andWhere('m.user = :user')
            ->setParameter('month', "$month%")
            ->setParameter('user', $userId)
            ->groupBy('m.type')
            ->orderBy('m.type', 'asc')
            ->getQuery()->getResult();
    }

    public function findTotalStatusInMonth(string $month, int $userId): array
    {
        $repo = $this->setRepository();
        $q = $repo->createQueryBuilder('m');
        return $q->select('sum(m.value) as total, m.status')
            ->where('m.date LIKE :month')
            ->andWhere('m.user = :user')
            ->setParameter('month', "$month%")
            ->setParameter('user', $userId)
            ->groupBy('m.status')
            ->orderBy('m.status', 'asc')
            ->getQuery()->getResult();
    }
}