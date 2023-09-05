<?php

namespace App\Application\Actions\Movement;

use Psr\Http\Message\ResponseInterface as Response;

class ListAllAction extends MovementAction
{    
    protected function action(): Response
    {
        $movements = $this->movementRepository->findAll();
        return $this->respondWithData($movements);
    }
}