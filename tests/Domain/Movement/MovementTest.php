<?php

declare(strict_types=1);

namespace Tests\Domain\Movement;

use App\Domain\Category\Category;
use App\Domain\User\User;
use Tests\TestCase;

class MovementTest extends TestCase
{
    public function movementProvider(): array
    {
        return [
            [1, 1, 0]
        ];
    }

    /**
     * @dataProvider movementProvider
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
     * @dataProvider movementProvider
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
            'createdAt' => $createdAt->format('Y-m-d H:i:s')
        ]);

        $this->assertEquals($expectedPayload, json_encode($category));
    }
}
