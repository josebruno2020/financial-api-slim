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

class CreateMovementActionTest extends TestCase
{
    use MovementActionTestHelper;

    public function testAction()
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();

        $movement = $this->createMockMovement();

        $data = ['type' => 0, 'value' => 50.0, 'obs' => 'Legal', 'category_id' => 1];

        $movementRepositoryProphecy = $this->prophesize(MovementRepository::class);
        $movementRepositoryProphecy
            ->createMovement($data)
            ->willReturn($movement)
            ->shouldBeCalledOnce();

        $container->set(MovementRepository::class, $movementRepositoryProphecy->reveal());
        $container->set(MovementRepository::class, $movementRepositoryProphecy->reveal());

        $request = $this->createRequest('POST', '/movements')->withParsedBody($data);
        $response = $app->handle($request);

        $payload = (string)$response->getBody();
        $expectedPayload = new ActionPayload(201, $movement);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
