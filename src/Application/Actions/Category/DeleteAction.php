<?php

namespace App\Application\Actions\Category;

use Psr\Http\Message\ResponseInterface as Response;

class DeleteAction extends CategoryAction
{   
    protected function action(): Response
    {
        $id = $this->resolveArg('id');
        $this->categoryRepository->deleteById($id);
        return $this->respondWithData(statusCode: 204);
    }
}