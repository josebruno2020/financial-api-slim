<?php

declare(strict_types=1);

namespace Tests;

use App\Application\Helper\RouteHelper;
use App\Domain\User\User;
use DI\ContainerBuilder;
use Exception;
use PHPUnit\Framework\TestCase as PHPUnit_TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Request as SlimRequest;
use Slim\Psr7\Uri;

class TestCase extends PHPUnit_TestCase
{
    use ProphecyTrait;

    /**
     * @return App
     * @throws Exception
     */
    protected function getAppInstance(): App
    {
        // Instantiate PHP-DI ContainerBuilder
        $containerBuilder = new ContainerBuilder();

        // Container intentionally not compiled for tests.

        // Set up settings
        $settings = require __DIR__ . '/../app/settings.php';
        $settings($containerBuilder);

        // Set up dependencies
        $dependencies = require __DIR__ . '/../app/dependencies.php';
        $dependencies($containerBuilder);

        // Set up repositories
        $repositories = require __DIR__ . '/../app/repositories.php';
        $repositories($containerBuilder);

        // Build PHP-DI Container instance
        $container = $containerBuilder->build();

        // Instantiate the app
        AppFactory::setContainer($container);
        $app = AppFactory::create();

        // Register middleware
        $middleware = require __DIR__ . '/../app/middleware.php';
        $middleware($app);

        // Register routes
        $routes = require __DIR__ . '/../app/routes.php';
        $routesDir = __DIR__ . '/../app/routes';
        RouteHelper::loadAllRoutesFromDir($routesDir, $app);
        $routes($app);

        return $app;
    }

    /**
     * @param string $method
     * @param string $path
     * @param array $headers
     * @param array $cookies
     * @param array $serverParams
     * @param User|null $user
     * @return Request
     */
    protected function createRequest(
        string $method,
        string $path,
        array  $headers = ['HTTP_ACCEPT' => 'application/json'],
        array  $cookies = [],
        array  $serverParams = ['TEST_MODE' => true],
        ?User  $user = null
    ): Request
    {
        $uri = new Uri('', '', 80, $path);
        $handle = fopen('php://temp', 'w+');
        $stream = (new StreamFactory())->createStreamFromResource($handle);

        $h = new Headers();
        foreach ($headers as $name => $value) {
            $h->addHeader($name, $value);
        }

        $request = new SlimRequest($method, $uri, $h, $cookies, $serverParams, $stream);

        if ($user) {
            $request = $request->withAttribute('userId', $user->getId());
        }

        return $request;
    }
}
