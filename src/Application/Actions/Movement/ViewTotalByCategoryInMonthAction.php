<?php

namespace App\Application\Actions\Movement;

use App\Application\Helper\RequestHelper;
use App\Domain\Enums\MovementTypeEnum;
use Psr\Http\Message\ResponseInterface as Response;

class ViewTotalByCategoryInMonthAction extends MovementAction
{    
    protected function action(): Response
    {
        $queryParams = $this->request->getQueryParams();
        $month = $queryParams['month'] ?? date('Y-m');
        $type = $queryParams['type'] ?? MovementTypeEnum::OUTFLOW->value;
        
        $totals = $this->movementRepository->findTotalByTypeAndCategoryInMonth(
            $month,
            type: MovementTypeEnum::make($type),
            userId: RequestHelper::getUserIdFromRequest($this->request)
        );
        
        $result = compact('type', 'totals');
        
        return $this->respondWithData($result);
    }
}