<?php

namespace App\Application\Actions\Movement;

use Psr\Http\Message\ResponseInterface as Response;

class CreateAction extends MovementAction
{    
    protected function action(): Response
    {
        $data = $this->getBody();
        $movements = $this->movementRepository->createMovement($data);
        return $this->respondWithData($movements, statusCode: 201);
    }
}