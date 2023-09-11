<?php

namespace App\Application\Actions\Movement\MovementGroup;

use App\Application\Helper\RequestHelper;
use App\Domain\Enums\MovementTypeEnum;
use Psr\Http\Message\ResponseInterface as Response;

class ViewGroupTotalByMonthAction extends MovementGroupAction
{    
    protected function action(): Response
    {
        $queryParams = $this->request->getQueryParams();
        $month = $queryParams['month'] ?? date('Y-m');
        $type = $queryParams['type'] ?? MovementTypeEnum::OUTFLOW->value;

        $totals = $this->movementGroupRepository->findTotalByTypeAndCategoryInMonth(
            groupId: RequestHelper::getGroupIdFromRequest($this->request),
            month: $month,
            type: MovementTypeEnum::make($type),
        );

        $result = compact('type', 'totals');

        return $this->respondWithData($result);
    }
}