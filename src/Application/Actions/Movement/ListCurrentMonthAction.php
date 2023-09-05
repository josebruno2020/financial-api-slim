<?php

namespace App\Application\Actions\Movement;

use Psr\Http\Message\ResponseInterface as Response;

class ListCurrentMonthAction extends MovementAction
{    
    protected function action(): Response
    {
        $movements = $this->movementRepository->findAllInCurrentMonth();
        return $this->respondWithData($movements);
    }
}