<?php

namespace App\Application\Helper;

use Psr\Http\Message\ServerRequestInterface as Request;

class RequestHelper
{
    public static function getUserIdFromRequest(Request $request): int
    {
        return $request->getAttribute('userId');
    }
}