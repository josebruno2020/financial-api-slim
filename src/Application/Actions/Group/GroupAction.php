<?php

declare(strict_types=1);

namespace App\Application\Actions\Group;

use App\Application\Actions\Action;
use App\Domain\Group\GroupRepository;
use Psr\Log\LoggerInterface;

abstract class GroupAction extends Action
{
    public function __construct(
        LoggerInterface           $logger,
        protected GroupRepository $groupRepository
    )
    {
        parent::__construct($logger);
    }
}