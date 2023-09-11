<?php

namespace App\Application\Helper;

use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpBadRequestException;

class RequestHelper
{
    public static function getUserIdFromRequest(Request $request): int
    {
        return $request->getAttribute('userId');
    }

    public static function getGroupIdFromRequest(Request $request): int
    {
        $params = $request->getQueryParams();
        if (!isset($params['group_id'])) {
            throw new HttpBadRequestException($request, 'Parâmetro [group_id] inválido');
        }
        return intval($params['group_id']);
    }
}