<?php

declare(strict_types=1);

namespace Tests\Application\Actions\Movement;

use App\Application\Actions\ActionPayload;
use App\Domain\Category\Category;
use App\Domain\Category\CategoryRepository;
use App\Domain\Enums\MovementTypeEnum;
use App\Domain\Movement\MovementRepository;
use DI\Container;
use Prophecy\Argument;
use Tests\TestCase;

class ViewTotalByCategoryAndTypeInMonthActionTest extends TestCase
{
    use MovementActionTestHelper;

    public function testAction()
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();

        $type = 1;
        $totals = [
            ['Categoria 1' => 52.1]
        ];

        $movementRepositoryProphecy = $this->prophesize(MovementRepository::class);
        $movementRepositoryProphecy
            ->findTotalByTypeAndCategoryInMonth(Argument::type('string'), Argument::type(MovementTypeEnum::class))
            ->willReturn($totals)
            ->shouldBeCalledOnce();

        $container->set(MovementRepository::class, $movementRepositoryProphecy->reveal());

        $request = $this->createRequest('GET', "/movements/total-category");
        $response = $app->handle($request);

        $payload = (string)$response->getBody();
        $expectedPayload = new ActionPayload(200, compact('type', 'totals'));
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
