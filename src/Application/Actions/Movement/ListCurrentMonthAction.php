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
        $movements = $this->movementRepository->findAllInCurrentMonth(
            userId: RequestHelper::getUserIdFromRequest($this->request),
            categoryId: intval($categoryId),
            type: $type ? MovementTypeEnum::make($type) : null
        );
        return $this->respondWithData($movements);
    }
}