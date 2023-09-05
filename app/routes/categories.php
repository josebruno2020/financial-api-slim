<?php

use App\Application\Actions\Category\CreateAction;
use App\Application\Actions\Category\DeleteAction;
use App\Application\Actions\Category\ListAction;
use App\Application\Actions\Category\UpdateAction;
use App\Application\Actions\Category\ViewAction;
use App\Application\Middleware\CategoryCreateValidationMiddleware;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->group('/categories', function (Group $group) {
        $group->get('', ListAction::class);
        $group->get('/{id}', ViewAction::class);
        $group->post('', CreateAction::class)->add(CategoryCreateValidationMiddleware::class);
        $group->put('/{id}', UpdateAction::class)->add(CategoryCreateValidationMiddleware::class);
        $group->delete('/{id}', DeleteAction::class);
    });
};