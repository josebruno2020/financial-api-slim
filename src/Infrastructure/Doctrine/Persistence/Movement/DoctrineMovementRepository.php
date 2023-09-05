<?php

namespace App\Infrastructure\Doctrine\Persistence\Movement;

use App\Domain\Movement\Movement;
use App\Domain\Movement\MovementRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Exception\NotSupported;

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
}