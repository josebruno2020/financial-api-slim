<?php

declare(strict_types=1);

namespace Tests\Application\Actions\Movement;

use App\Application\Actions\ActionPayload;
use App\Domain\Movement\MovementRepository;
use DI\Container;
use Tests\Application\Actions\User\UserActionTestHelper;
use Tests\TestCase;

class DeleteMovementActionTest extends TestCase
{
    use MovementActionTestHelper;
    use UserActionTestHelper;

    public function testDeleteMovementAction()
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();

        $user = $this->createMockUser();
        $movement = $this->createMockMovement();

        $movementRepositoryProphecy = $this->prophesize(MovementRepository::class);
        $movementRepositoryProphecy
            ->deleteMovementById(id: $movement->getId(), userId: $user->getId())
            ->shouldBeCalledOnce()
            ->hasReturnVoid();

        $container->set(MovementRepository::class, $movementRepositoryProphecy->reveal());

        $request = $this->createRequest('DELETE', "/movements/{$movement->getId()}", user: $user);
        $response = $app->handle($request);

        $payload = (string)$response->getBody();
        $expectedPayload = new ActionPayload(204);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
