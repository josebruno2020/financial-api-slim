<?php

declare(strict_types=1);

namespace Tests\Application\Actions\Category;

use App\Application\Actions\ActionPayload;
use App\Domain\Category\Category;
use App\Domain\Category\CategoryRepository;
use DI\Container;
use Tests\TestCase;

class UpdateCategoryActionTest extends TestCase
{
    use CategoryActionTestHelper;

    public function testAction()
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();

        $data = ['name' => 'Categoria Atualizada'];
        $category = $this->createCategoryMock();

        $categoryRepositoryProphecy = $this->prophesize(CategoryRepository::class);
        $categoryRepositoryProphecy
            ->updateCategoryById($category->getId(), $data)
            ->shouldBeCalledOnce()
            ->hasReturnVoid();

        $container->set(CategoryRepository::class, $categoryRepositoryProphecy->reveal());

        $request = $this->createRequest('PUT', "/categories/{$category->getId()}")->withParsedBody($data);
        $response = $app->handle($request);

        $payload = (string)$response->getBody();
        $expectedPayload = new ActionPayload(204);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
