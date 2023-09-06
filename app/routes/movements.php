<?php

use App\Application\Actions\Movement\CreateAction;
use App\Application\Actions\Movement\DeleteAction;
use App\Application\Actions\Movement\ListAllAction;
use App\Application\Actions\Movement\ListCurrentMonthAction;
use App\Application\Actions\Movement\ViewAction;
use App\Application\Actions\Movement\ViewTotalByCategoryInMonthAction;
use App\Application\Middleware\AuthVerifyMiddleware;
use App\Application\Middleware\MovementValidationMiddleware;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->group('/movements', function (Group $group) {
        $group->get('', ListAllAction::class);
        $group->get('/current-month', ListCurrentMonthAction::class);
        $group->get('/total-category', ViewTotalByCategoryInMonthAction::class);
        $group->get('/{id}', ViewAction::class);
        $group->post('', CreateAction::class)->add(MovementValidationMiddleware::class);
        $group->delete('/{id}', DeleteAction::class);
    })->add(AuthVerifyMiddleware::class);
};