<?php

namespace App\Application\Actions\Category;

use Psr\Http\Message\ResponseInterface as Response;

class CreateAction extends CategoryAction
{
    
    protected function action(): Response
    {
        $data = $this->getBody();
        $category = $this->categoryRepository->createCategory($data);
        return $this->respondWithData($category, statusCode: 201);
    }
}