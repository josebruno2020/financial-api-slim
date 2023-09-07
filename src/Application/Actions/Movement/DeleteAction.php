<?php

namespace App\Application\Actions\Movement;

use App\Application\Helper\RequestHelper;
use Psr\Http\Message\ResponseInterface as Response;

class DeleteAction extends MovementAction
{    
    protected function action(): Response
    {
        $id = $this->resolveArg('id');
        $this->movementRepository->deleteMovementById(
            $id,
            RequestHelper::getUserIdFromRequest($this->request)
        );
        return $this->respondWithData(statusCode: 204);
    }
}