<?php

declare(strict_types=1);

namespace Tests\Application\Actions\Movement;

use App\Application\Actions\ActionPayload;
use App\Domain\Movement\MovementRepository;
use DI\Container;
use Tests\Application\Actions\User\UserActionTestHelper;
use Tests\TestCase;

class ListAllMovementsActionTest extends TestCase
{
    use MovementActionTestHelper;
    use UserActionTestHelper;

    public function testAction()
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();

        $user = $this->createMockUser();
        $movement = $this->createMockMovement();

        $movementRepositoryProphecy = $this->prophesize(MovementRepository::class);
        $movementRepositoryProphecy
            ->findAll(userId: $user->getId())
            ->willReturn([$movement])
            ->shouldBeCalledOnce();

        $container->set(MovementRepository::class, $movementRepositoryProphecy->reveal());

        $request = $this->createRequest('GET', '/movements', user: $user);
        $response = $app->handle($request);

        $payload = (string)$response->getBody();
        $expectedPayload = new ActionPayload(200, [$movement]);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
