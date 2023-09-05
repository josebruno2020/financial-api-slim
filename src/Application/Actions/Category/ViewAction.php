<?php

namespace App\Application\Actions\Category;

use App\Domain\DomainException\DomainRecordNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

class ViewAction extends CategoryAction
{   
    protected function action(): Response
    {
        $id = $this->resolveArg('id');
        $category = $this->categoryRepository->findCategoryById($id);
        return $this->respondWithData($category);
    }
}