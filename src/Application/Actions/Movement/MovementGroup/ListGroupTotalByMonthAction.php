<?php

namespace App\Application\Actions\Movement\MovementGroup;

use App\Application\Helper\RequestHelper;
use Psr\Http\Message\ResponseInterface as Response;

class ListGroupTotalByMonthAction extends MovementGroupAction
{    
    protected function action(): Response
    {
        $queryParams = $this->request->getQueryParams();
        $month = $queryParams['month'] ?? date('Y-m');

        $totals = $this->movementGroupRepository->findTotalTypeInMonth(
            groupId: RequestHelper::getGroupIdFromRequest($this->request),
            month: $month
        );

        return $this->respondWithData($totals);
    }
}