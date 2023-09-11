<?php

declare(strict_types=1);

namespace App\Application\Actions\Group;

use App\Application\Helper\RequestHelper;
use Psr\Http\Message\ResponseInterface as Response;

class ListByUserAction extends GroupAction
{
    protected function action(): Response
    {
        $userId = RequestHelper::getUserIdFromRequest($this->request);
        $groups = $this->groupRepository->listByUserId($userId);

        return $this->respondWithData($groups);
    }
}