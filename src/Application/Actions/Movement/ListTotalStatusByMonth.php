<?php

namespace App\Application\Actions\Movement;

use App\Application\Helper\RequestHelper;
use Psr\Http\Message\ResponseInterface as Response;

class ListTotalStatusByMonth extends MovementAction
{    
    protected function action(): Response
    {
        $queryParams = $this->request->getQueryParams();
        $month = $queryParams['month'] ?? date('Y-m');

        $totals = $this->movementRepository->findTotalStatusInMonth(
            $month,
            userId: RequestHelper::getUserIdFromRequest($this->request)
        );

        return $this->respondWithData($totals);
    }
}