<?php

use App\Application\Actions\PaymentForm\ListAllAction;
use App\Application\Middleware\AuthVerifyMiddleware;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->group('/payment-forms', function (Group $group) {
        $group->get('', ListAllAction::class);
    })->add(AuthVerifyMiddleware::class);
};