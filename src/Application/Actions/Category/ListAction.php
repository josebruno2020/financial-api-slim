<?php

namespace App\Application\Actions\Category;

use App\Application\Helper\RequestHelper;
use App\Domain\DomainException\DomainRecordNotFoundException;
use App\Domain\Enums\MovementTypeEnum;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

class ListAction extends CategoryAction
{   
    protected function action(): Response
    {
        $params = $this->request->getQueryParams();
        $order = $params['order'] ?? 'asc';
        $type = $params['type'] ?? MovementTypeEnum::OUTFLOW->value;
        $categories = $this->categoryRepository->listCategories(
            userId: RequestHelper::getUserIdFromRequest($this->request),
            order: $order,
            type: $type
        );
        return $this->respondWithData($categories);
    }
}