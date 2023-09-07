<?php

use App\Application\Actions\Balance\ViewBalanceAction;
use App\Application\Middleware\AuthVerifyMiddleware;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->group('/balances', function (Group $group) {
        $group->get('', ViewBalanceAction::class);
    })->add(AuthVerifyMiddleware::class);
};