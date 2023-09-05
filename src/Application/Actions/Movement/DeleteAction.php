<?php

namespace App\Application\Actions\Movement;

use Psr\Http\Message\ResponseInterface as Response;

class DeleteAction extends MovementAction
{    
    protected function action(): Response
    {
        $id = $this->resolveArg('id');
        $this->movementRepository->deleteMovementById($id);
        return $this->respondWithData(statusCode: 204);
    }
}