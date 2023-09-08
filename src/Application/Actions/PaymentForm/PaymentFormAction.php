<?php

declare(strict_types=1);

namespace App\Application\Actions\PaymentForm;

use App\Application\Actions\Action;
use App\Domain\Movement\MovementRepository;
use App\Domain\PaymentForm\PaymentFormRepository;
use Psr\Log\LoggerInterface;

abstract class PaymentFormAction extends Action
{

    public function __construct(
        LoggerInterface                          $logger,
        protected readonly PaymentFormRepository $paymentFormRepository
    )
    {
        parent::__construct($logger);
        $this->logger = $logger;
    }
}