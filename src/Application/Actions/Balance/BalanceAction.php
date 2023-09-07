<?php

declare(strict_types=1);

namespace App\Application\Actions\Balance;

use App\Application\Actions\Action;
use App\Domain\Balance\BalanceRepository;
use App\Domain\Movement\MovementRepository;
use Psr\Log\LoggerInterface;

abstract class BalanceAction extends Action
{
    public function __construct(LoggerInterface $logger, protected readonly BalanceRepository $balanceRepository)
    {
        parent::__construct($logger);
        $this->logger = $logger;
    }
}