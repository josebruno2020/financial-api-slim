<?php

namespace App\Application\Actions\Movement;

use Psr\Http\Message\ResponseInterface as Response;

class ViewAction extends MovementAction
{    
    protected function action(): Response
    {
        $id = $this->resolveArg('id');
        $movement = $this->movementRepository->findMovementById($id);
        return $this->respondWithData($movement);
    }
}