<?php

declare(strict_types=1);

namespace App\Application\Actions\Movement;

use App\Application\Actions\Action;
use App\Domain\Movement\MovementRepository;
use Psr\Log\LoggerInterface;

abstract class MovementAction extends Action
{
    protected MovementRepository $movementRepository;

    public function __construct(LoggerInterface $logger, MovementRepository $movementRepository)
    {
        parent::__construct($logger);
        $this->logger = $logger;
        $this->movementRepository = $movementRepository;
    }
}