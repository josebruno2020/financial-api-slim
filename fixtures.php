<?php

use App\Domain\User\PasswordRepository;
use App\Infrastructure\Doctrine\Fixtures\PaymentFormLoader;
use App\Infrastructure\Doctrine\Fixtures\UserLoader;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;

require_once __DIR__ . '/vendor/autoload.php';
$settings = require_once __DIR__ . '/app/settings.php';
$dependencies = require_once __DIR__ . '/app/dependencies.php';

$containerBuild = new \DI\ContainerBuilder();
$settings($containerBuild);
$dependencies($containerBuild);
$container = $containerBuild->build();

$dir = __DIR__ . '/src/Infrastructure/Doctrine/Fixtures';

$loader = new Loader();
$loader->addFixture(new PaymentFormLoader());
$loader->addFixture(new UserLoader($container->get(PasswordRepository::class)));


$executor = new ORMExecutor($container->get(EntityManager::class), new ORMPurger());
$executor->execute($loader->getFixtures());

echo "Fixtures enviadas com sucesso";