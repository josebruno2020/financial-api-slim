<?php

namespace App\Application\Actions\Movement\MovementGroup;

use App\Application\Helper\RequestHelper;
use App\Domain\Enums\MovementTypeEnum;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

class ListGroupCurrentMonthAction extends MovementGroupAction
{    
    protected function action(): Response
    {
        $params = $this->request->getQueryParams();
        $categoryId = $params['category_id'] ?? null;
        $type = $params['type'] ?? null;
        $month = $queryParams['month'] ?? date('Y-m');
        $movements = $this->movementGroupRepository->findAllInMonth(
            groupId: RequestHelper::getGroupIdFromRequest($this->request),
            month: $month,
            categoryId: is_numeric($categoryId) ? intval($categoryId) : null,
            type: is_numeric($type) ? MovementTypeEnum::make($type) : null
        );
        return $this->respondWithData($movements);
    }
}