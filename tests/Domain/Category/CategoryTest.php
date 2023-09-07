<?php

declare(strict_types=1);

namespace Tests\Domain\Category;

use App\Domain\Category\Category;
use App\Domain\User\User;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    public function categoryProvider(): array
    {
        return [
            [1, 'Categoria 1']
        ];
    }

    /**
     * @dataProvider categoryProvider
     * @param int $id
     * @param string $name
     */
    public function testGetters(int $id, string $name)
    {
        $category = new Category(id: $id, name: $name);
        $createdAt = new \DateTime();

        $this->assertEquals($id, $category->getId());
        $this->assertEquals($name, $category->getName());
        $this->assertEquals($createdAt->format('Y-m-d H:i:s'), $category->getCreatedAt());
    }

    /**
     * @dataProvider categoryProvider
     * @param int $id
     * @param string $name
     */
    public function testJsonSerialize(int $id, string $name)
    {
        $category = new Category($id, $name);
        $createdAt = new \DateTime();

        $expectedPayload = json_encode([
            'id' => $id,
            'name' => $name,
            'user' => null,
            'createdAt' => $createdAt->format('Y-m-d H:i:s')
        ]);

        $this->assertEquals($expectedPayload, json_encode($category));
    }
}
