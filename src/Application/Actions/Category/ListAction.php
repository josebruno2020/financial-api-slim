<?php

namespace App\Application\Actions\Category;

use App\Domain\DomainException\DomainRecordNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

class ListAction extends CategoryAction
{   
    protected function action(): Response
    {
        $order = $this->request->getQueryParams()['order'] ?? 'asc';
        $categories = $this->categoryRepository->listCategories($order);
        return $this->respondWithData($categories);
    }
}