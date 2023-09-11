<?php

declare(strict_types=1);

namespace App\Application\Actions\Group;

use App\Application\Helper\RequestHelper;
use Psr\Http\Message\ResponseInterface as Response;

class CreateGroupAction extends GroupAction
{

    protected function action(): Response
    {
        $data = $this->getBody();
        $data['userId'] = RequestHelper::getUserIdFromRequest($this->request);
        $group = $this->groupRepository->createGroup($data);
        return $this->respondWithData($group, statusCode: 201);
    }
}