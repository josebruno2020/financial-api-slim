<?php

namespace App\Application\Actions\Category;

use Psr\Http\Message\ResponseInterface as Response;

class UpdateAction extends CategoryAction
{

    protected function action(): Response
    {
        $id = $this->resolveArg('id');
        $data = $this->getBody();
        $this->categoryRepository->updateCategoryById($id, $data);
        return $this->respondWithData(statusCode: 204);
    }
}