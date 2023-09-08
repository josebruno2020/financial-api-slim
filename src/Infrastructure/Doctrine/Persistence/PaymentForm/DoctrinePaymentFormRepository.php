<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Persistence\PaymentForm;

use App\Domain\PaymentForm\PaymentForm;
use App\Domain\PaymentForm\PaymentFormRepository;
use Doctrine\ORM\EntityManager;

class DoctrinePaymentFormRepository implements PaymentFormRepository
{
    public function __construct(
        private readonly EntityManager $entityManager
    )
    {
    }

    /**
     * @return PaymentForm[]
     */
    public function findAll(): array
    {
        $repo = $this->entityManager->getRepository(PaymentForm::class);
        return $repo->findAll();
    }
}