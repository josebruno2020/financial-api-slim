<?php

use App\Application\Actions\Group\CreateGroupAction;
use App\Application\Actions\Group\ListByUserAction;
use App\Application\Actions\Group\ListUsersGroupAction;
use App\Application\Actions\Group\ViewGroupAction;
use App\Application\Middleware\AuthVerifyMiddleware;
use App\Application\Middleware\GroupValidationMiddleware;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->group('/groups', function (Group $group) {
        $group->post('', CreateGroupAction::class)->add(GroupValidationMiddleware::class);
        $group->get('/my', ListByUserAction::class);
        $group->get('/users/{id}', ListUsersGroupAction::class);
        $group->get('/{id}', ViewGroupAction::class);
    })->add(AuthVerifyMiddleware::class);
};