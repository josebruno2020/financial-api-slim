<?php

declare(strict_types=1);

namespace App\Application\Actions\Group;

use Psr\Http\Message\ResponseInterface as Response;

class ViewGroupAction extends GroupAction
{
    protected function action(): Response
    {
        $id = $this->resolveArg('id');
        $group = $this->groupRepository->findGroupById(id: intval($id));

        return $this->respondWithData($group);
    }
}