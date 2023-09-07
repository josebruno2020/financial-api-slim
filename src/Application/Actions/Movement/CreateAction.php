<?php

namespace App\Application\Actions\Movement;

use App\Application\Helper\RequestHelper;
use Psr\Http\Message\ResponseInterface as Response;

class CreateAction extends MovementAction
{    
    protected function action(): Response
    {
        $data = $this->getBody();
        $data['userId'] = RequestHelper::getUserIdFromRequest($this->request);
        $movements = $this->movementRepository->createMovement($data);
        return $this->respondWithData($movements, statusCode: 201);
    }
}