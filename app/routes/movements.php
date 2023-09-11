<?php

use App\Application\Actions\Movement\CreateAction;
use App\Application\Actions\Movement\DeleteAction;
use App\Application\Actions\Movement\ListAllAction;
use App\Application\Actions\Movement\ListCurrentMonthAction;
use App\Application\Actions\Movement\ListTotalByMonthAction;
use App\Application\Actions\Movement\ListTotalStatusByMonth;
use App\Application\Actions\Movement\MovementGroup\ListGroupCurrentMonthAction;
use App\Application\Actions\Movement\MovementGroup\ListGroupTotalByMonthAction;
use App\Application\Actions\Movement\MovementGroup\ListGroupTotalStatusByMonth;
use App\Application\Actions\Movement\MovementGroup\ViewGroupTotalByMonthAction;
use App\Application\Actions\Movement\ViewAction;
use App\Application\Actions\Movement\ViewTotalByCategoryInMonthAction;
use App\Application\Middleware\AuthVerifyMiddleware;
use App\Application\Middleware\MovementGroupValidationMiddleware;
use App\Application\Middleware\MovementValidationMiddleware;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->group('/movements/groups', function (Group $group) {
        $group->get('/current-month', ListGroupCurrentMonthAction::class);
        $group->get('/total-month', ListGroupTotalByMonthAction::class);
        $group->get('/total-status', ListGroupTotalStatusByMonth::class);
        $group->get('/total-category', ViewGroupTotalByMonthAction::class);
    })
        ->add(MovementGroupValidationMiddleware::class)
        ->add(AuthVerifyMiddleware::class);

    $app->group('/movements', function (Group $group) {
        $group->get('', ListAllAction::class);
        $group->get('/current-month', ListCurrentMonthAction::class);
        $group->get('/total-category', ViewTotalByCategoryInMonthAction::class);
        $group->get('/total-month', ListTotalByMonthAction::class);
        $group->get('/total-status', ListTotalStatusByMonth::class);
        $group->get('/{id}', ViewAction::class);
        $group->post('', CreateAction::class)->add(MovementValidationMiddleware::class);
        $group->delete('/{id}', DeleteAction::class);
    })->add(AuthVerifyMiddleware::class);
};