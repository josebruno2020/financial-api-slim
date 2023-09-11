<?php

namespace App\Application\Actions\Movement;

use App\Application\Helper\RequestHelper;
use App\Domain\Enums\MovementTypeEnum;
use Psr\Http\Message\ResponseInterface as Response;

class ListCurrentMonthAction extends MovementAction
{    
    protected function action(): Response
    {
        $params = $this->request->getQueryParams();
        $categoryId = $params['category_id'] ?? null;
        $type = $params['type'] ?? null;
        $month = $queryParams['month'] ?? date('Y-m');
        $movements = $this->movementRepository->findAllInMonth(
            userId: RequestHelper::getUserIdFromRequest($this->request),
            month: $month,
            categoryId: is_numeric($categoryId) ? intval($categoryId) : null,
            type: is_numeric($type) ? MovementTypeEnum::make($type) : null
        );
        return $this->respondWithData($movements);
    }
}