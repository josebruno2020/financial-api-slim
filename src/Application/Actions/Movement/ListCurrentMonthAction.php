<?php

namespace App\Application\Actions\Movement;

use App\Application\Helper\RequestHelper;
use Psr\Http\Message\ResponseInterface as Response;

class ListCurrentMonthAction extends MovementAction
{    
    protected function action(): Response
    {
        $movements = $this->movementRepository->findAllInCurrentMonth(
            RequestHelper::getUserIdFromRequest($this->request)
        );
        return $this->respondWithData($movements);
    }
}