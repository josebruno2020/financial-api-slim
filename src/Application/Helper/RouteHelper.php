<?php

namespace App\Application\Helper;

use Slim\App;

class RouteHelper
{
    public static function loadAllRoutesFromDir(string $dir, App $app): void
    {
        $routesFiles = scandir($dir);
        foreach ($routesFiles as $routesFile) {
            if (!str_contains($routesFile, '.php')) continue;
            $routeHandle = require "$dir/$routesFile";
            $routeHandle($app);
        }
    }
}