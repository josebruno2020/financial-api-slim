<?php

namespace App\Infrastructure\Doctrine\Persistence\Movement;

use App\Domain\Enums\MovementTypeEnum;
use App\Domain\Movement\Movement;
use App\Domain\Movement\MovementGroupRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class DoctineMovementGroupRepository implements MovementGroupRepository
{
    public function __construct(
        private readonly EntityManager $entityManager
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
    public function findAllInMonth(int $groupId, string $month, ?int $categoryId = null, ?MovementTypeEnum $type = null): array
    {
        $repo = $this->setRepository();
        $q = $repo->createQueryBuilder('m')
            ->where('m.date LIKE :month')
            ->andWhere('m.group = :group')
            ->setParameter('month', "$month%")
            ->setParameter('group', $groupId);
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

    public function findTotalByTypeAndCategoryInMonth(int $groupId, string $month, MovementTypeEnum $type): array
    {
        $repo = $this->setRepository();
        $q = $repo->createQueryBuilder('m');
        return $q->select('sum(m.value) as total, c.name, c.id')
            ->join('m.category', 'c')
            ->where('m.date LIKE :month')
            ->andWhere('m.type = :type')
            ->andWhere('m.group = :groupId')
            ->setParameter('month', "$month%")
            ->setParameter('type', $type->value)
            ->setParameter('groupId', $groupId)
            ->groupBy('c.id')
            ->orderBy('sum(m.value)', 'desc')
            ->getQuery()
            ->getResult();
    }

    public function findTotalTypeInMonth(int $groupId, string $month): array
    {
        $repo = $this->setRepository();
        $q = $repo->createQueryBuilder('m');
        return $q->select('sum(m.value) as total, m.type')
            ->where('m.date LIKE :month')
            ->andWhere('m.group = :groupId')
            ->setParameter('month', "$month%")
            ->setParameter('groupId', $groupId)
            ->groupBy('m.type')
            ->orderBy('m.type', 'asc')
            ->getQuery()->getResult();
    }

    public function findTotalStatusInMonth(int $groupId, string $month): array
    {
        $repo = $this->setRepository();
        $q = $repo->createQueryBuilder('m');
        return $q->select('sum(m.value) as total, m.status')
            ->where('m.date LIKE :month')
            ->andWhere('m.group = :groupId')
            ->setParameter('month', "$month%")
            ->setParameter('groupId', $groupId)
            ->groupBy('m.status')
            ->orderBy('m.status', 'asc')
            ->getQuery()->getResult();
    }
}