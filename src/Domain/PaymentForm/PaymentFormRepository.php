<?php

declare(strict_types=1);

namespace App\Domain\PaymentForm;

interface PaymentFormRepository
{
    /**
     * @return PaymentForm[]
     */
    public function findAll(int $userId): array;
}