<?php

use App\Application\Actions\Auth\LoginAction;
use App\Application\Middleware\LoginValidationMiddleware;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->group('/auth', function (Group $group) {
        $group->post('/login', LoginAction::class)->add(LoginValidationMiddleware::class);
    });
};