<?php

namespace App\Application\Actions\Movement;

use App\Application\Helper\RequestHelper;
use Psr\Http\Message\ResponseInterface as Response;

class ListAllAction extends MovementAction
{
    protected function action(): Response
    {
        $movements = $this->movementRepository->findAll(
            RequestHelper::getUserIdFromRequest($this->request)
        );
        return $this->respondWithData($movements);
    }
}