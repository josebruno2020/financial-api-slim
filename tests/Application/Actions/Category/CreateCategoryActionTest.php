<?php

declare(strict_types=1);

namespace Tests\Application\Actions\Category;

use App\Application\Actions\ActionPayload;
use App\Domain\Category\CategoryRepository;
use DI\Container;
use Tests\Application\Actions\User\UserActionTestHelper;
use Tests\TestCase;

class CreateCategoryActionTest extends TestCase
{
    use CategoryActionTestHelper;
    use UserActionTestHelper;

    public function testAction()
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();

        $user = $this->createMockUser();
        $data = ['name' => 'Categoria 1', 'userId' => $user->getId()];
        $category = $this->createCategoryMock();

        $categoryRepositoryProphecy = $this->prophesize(CategoryRepository::class);
        $categoryRepositoryProphecy
            ->createCategory($data)
            ->willReturn($category)
            ->shouldBeCalledOnce();

        $container->set(CategoryRepository::class, $categoryRepositoryProphecy->reveal());

        $request = $this->createRequest('POST', '/categories', user: $user)->withParsedBody($data);
        $response = $app->handle($request);

        $payload = (string)$response->getBody();
        $expectedPayload = new ActionPayload(201, $category);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
