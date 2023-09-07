<?php

declare(strict_types=1);

namespace Tests\Domain\Category;

use App\Domain\Category\Category;
use App\Domain\Enums\MovementTypeEnum;
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
        $category = new Category(name: $name, id: $id);
        $createdAt = new \DateTime();

        $this->assertEquals($id, $category->getId());
        $this->assertEquals($name, $category->getName());
        $this->assertEquals(MovementTypeEnum::OUTFLOW, $category->getType());
        $this->assertEquals($createdAt->format('Y-m-d H:i:s'), $category->getCreatedAt());
    }

    /**
     * @dataProvider categoryProvider
     * @param int $id
     * @param string $name
     */
    public function testJsonSerialize(int $id, string $name)
    {
        $category = new Category($name, id: $id);
        $createdAt = new \DateTime();

        $expectedPayload = json_encode([
            'id' => $id,
            'name' => $name,
            'user' => null,
            'type' => MovementTypeEnum::OUTFLOW,
            'createdAt' => $createdAt->format('Y-m-d H:i:s')
        ]);

        $this->assertEquals($expectedPayload, json_encode($category));
    }
}
