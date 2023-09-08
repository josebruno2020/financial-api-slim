<?php

namespace App\Application\Actions\Movement;

use App\Application\Helper\RequestHelper;
use App\Domain\Enums\MovementTypeEnum;
use Psr\Http\Message\ResponseInterface as Response;

class ListTotalByMonth extends MovementAction
{    
    protected function action(): Response
    {
        $queryParams = $this->request->getQueryParams();
        $month = $queryParams['month'] ?? date('Y-m');

        $totals = $this->movementRepository->findTotalTypeInMonth(
            $month,
            userId: RequestHelper::getUserIdFromRequest($this->request)
        );

        $result = compact('totals');

        return $this->respondWithData($totals);
    }
}