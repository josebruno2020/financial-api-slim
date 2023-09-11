<?php

declare(strict_types=1);

namespace Tests\Application\Actions\Category;

use App\Application\Actions\ActionPayload;
use App\Domain\Category\Category;
use App\Domain\Category\CategoryRepository;
use DI\Container;
use Tests\Application\Actions\User\UserActionTestHelper;
use Tests\TestCase;

class ListCategoriesActionTest extends TestCase
{
    use CategoryActionTestHelper;
    use UserActionTestHelper;

    public function testAction()
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();

        $user = $this->createMockUser();
        $category = $this->createCategoryMock();

        $categoryRepositoryProphecy = $this->prophesize(CategoryRepository::class);
        $categoryRepositoryProphecy
            ->listCategories(userId: $user->getId(), type: 1, order: 'asc')
            ->willReturn([$category])
            ->shouldBeCalledOnce();

        $container->set(CategoryRepository::class, $categoryRepositoryProphecy->reveal());

        $request = $this->createRequest('GET', '/categories', user: $user);
        $response = $app->handle($request);

        $payload = (string)$response->getBody();
        $expectedPayload = new ActionPayload(200, [$category]);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
