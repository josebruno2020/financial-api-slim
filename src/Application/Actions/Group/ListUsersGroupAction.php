<?php

declare(strict_types=1);

namespace App\Application\Actions\Group;

use App\Application\Helper\RequestHelper;
use Psr\Http\Message\ResponseInterface as Response;

class ListUsersGroupAction extends GroupAction
{
    protected function action(): Response
    {
        $id = $this->resolveArg('id');
        $users = $this->groupRepository->listUsersGroup(
            id: intval($id)
        );

        return $this->respondWithData($users);
    }
}