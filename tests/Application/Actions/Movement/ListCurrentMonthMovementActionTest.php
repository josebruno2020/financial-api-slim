<?php

declare(strict_types=1);

namespace Tests\Application\Actions\Movement;

use App\Application\Actions\ActionPayload;
use App\Domain\Category\Category;
use App\Domain\Category\CategoryRepository;
use App\Domain\Movement\Movement;
use App\Domain\Movement\MovementRepository;
use DI\Container;
use Tests\TestCase;

class ListCurrentMonthMovementActionTest extends TestCase
{
    public function testAction()
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();

        $category = new Category(name: 'Categoria 1');
        $movement = new Movement(
            category: $category,
            type: 0,
            value: 50.0,
            date: date('Y-m-d'),
            obs: 'Legal',
            id: 1
        );

        $movementRepositoryProphecy = $this->prophesize(MovementRepository::class);
        $movementRepositoryProphecy
            ->findAllInCurrentMonth()
            ->willReturn([$movement])
            ->shouldBeCalledOnce();

        $container->set(MovementRepository::class, $movementRepositoryProphecy->reveal());

        $request = $this->createRequest('GET', '/movements/current-month');
        $response = $app->handle($request);

        $payload = (string)$response->getBody();
        $expectedPayload = new ActionPayload(200, [$movement]);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
