<?php

declare(strict_types=1);

namespace App\Application\Actions\Group;

use App\Application\Helper\RequestHelper;
use Psr\Http\Message\ResponseInterface as Response;

class UpdateGroupAction extends GroupAction
{

    protected function action(): Response
    {
        $id = $this->resolveArg('id');
        $data = $this->getBody();
        $this->groupRepository->updateGroupById(
            id: intval($id),
            data: $data,
            userId: RequestHelper::getUserIdFromRequest($this->request)
            );
        return $this->respondWithData(statusCode: 204);
    }
}