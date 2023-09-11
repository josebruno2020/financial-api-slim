<?php

declare(strict_types=1);

namespace Tests\Application\Actions\Movement;

use App\Application\Actions\ActionPayload;
use App\Domain\Enums\MovementTypeEnum;
use App\Domain\Movement\MovementRepository;
use DI\Container;
use Prophecy\Argument;
use Tests\Application\Actions\User\UserActionTestHelper;
use Tests\TestCase;

class ListCurrentMonthMovementActionTest extends TestCase
{
    use MovementActionTestHelper;
    use UserActionTestHelper;

    public function testListCurrentMonthMovementAction()
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();

        $user = $this->createMockUser();
        $movement = $this->createMockMovement();

        $movementRepositoryProphecy = $this->prophesize(MovementRepository::class);
        $movementRepositoryProphecy
            ->findAllInMonth(userId: $user->getId(), categoryId: null, type: null)
            ->willReturn([$movement])
            ->shouldBeCalledOnce();

        $container->set(MovementRepository::class, $movementRepositoryProphecy->reveal());

        $request = $this->createRequest('GET', '/movements/current-month', user: $user);
        $response = $app->handle($request);

        $payload = (string)$response->getBody();
        $expectedPayload = new ActionPayload(200, [$movement]);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
