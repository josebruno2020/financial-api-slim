<?php

namespace App\Application\Actions\Category;

use App\Application\Helper\RequestHelper;
use Psr\Http\Message\ResponseInterface as Response;

class CreateAction extends CategoryAction
{
    
    protected function action(): Response
    {
        $data = $this->getBody();
        $data['userId'] = RequestHelper::getUserIdFromRequest($this->request);
        $category = $this->categoryRepository->createCategory($data);
        return $this->respondWithData($category, statusCode: 201);
    }
}