<?php

declare(strict_types=1);

namespace App\Application\Actions\Movement\MovementGroup;

use App\Application\Actions\Action;
use App\Domain\Movement\MovementGroupRepository;
use Psr\Log\LoggerInterface;

abstract class MovementGroupAction extends Action
{
    public function __construct(
        LoggerInterface $logger,
        protected MovementGroupRepository $movementGroupRepository
    )
    {
        parent::__construct($logger);
        $this->logger = $logger;
    }
}