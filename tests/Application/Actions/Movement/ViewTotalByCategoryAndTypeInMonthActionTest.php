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

class ViewTotalByCategoryAndTypeInMonthActionTest extends TestCase
{
    use MovementActionTestHelper;
    use UserActionTestHelper;

    public function testViewTotalByCategoryAndMonthAction()
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();

        $type = 1;
        $totals = [
            [
                'name' => 'Categoria 1',
                'id' => 1,
                'total' => 52.2
            ]
        ];
        $user = $this->createMockUser();
        $movementRepositoryProphecy = $this->prophesize(MovementRepository::class);
        $movementRepositoryProphecy
            ->findTotalByTypeAndCategoryInMonth(
                Argument::type('string'), Argument::type(MovementTypeEnum::class), userId: $user->getId()
            )
            ->willReturn($totals)
            ->shouldBeCalledOnce();

        $container->set(MovementRepository::class, $movementRepositoryProphecy->reveal());

        $request = $this->createRequest('GET', "/movements/total-category", user: $user);
        $response = $app->handle($request);

        $payload = (string)$response->getBody();
        $expectedPayload = new ActionPayload(200, compact('type', 'totals'));
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
