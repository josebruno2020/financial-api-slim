<?php

declare(strict_types=1);

namespace Tests\Domain\Movement;

use App\Domain\Category\Category;
use App\Domain\Enums\MovementTypeEnum;
use App\Domain\Movement\Movement;
use App\Domain\User\User;
use Tests\TestCase;

class MovementTest extends TestCase
{
    public function movementProvider(): array
    {
        return [
            [1, new Category(1, 'Categoria'), 0, 50.0, date('Y-m-d H:i:s'), 'Legal'],
            [1, new Category(2, 'Categoria 2'), 0, 120.5, null, null]
        ];
    }

    /**
     * @dataProvider movementProvider
     * @param int $id
     * @param Category $category
     * @param int $type
     * @param float $value
     * @param string|null $date
     * @param string|null $obs
     */
    public function testGetters(int $id, Category $category, int $type, float $value, ?string $date, ?string $obs)
    {
        $movement = new Movement(category: $category, type: $type, value: $value, date: $date, obs: $obs, id: $id);
        $dateTime = new \DateTime();
        $expectedDate = $date ?? date('Y-m-d H:i:s');

        $this->assertEquals($id, $movement->getId());
        $this->assertEquals($category, $movement->getCategory());
        $this->assertEquals(MovementTypeEnum::make($type), $movement->getType());
        $this->assertEquals($value, $movement->getValue());
        $this->assertEquals($expectedDate, $movement->getDate());
        $this->assertEquals($obs, $movement->getObs());
        $this->assertEquals($dateTime->format('Y-m-d H:i:s'), $movement->getCreatedAt());
        $this->assertEquals($dateTime->format('Y-m-d H:i:s'), $movement->getUpdatedAt());
    }

    /**
     * @dataProvider movementProvider
     * @param int $id
     * @param Category $category
     * @param int $type
     * @param float $value
     * @param string|null $date
     * @param string|null $obs
     */
    public function testJsonSerialize(int $id, Category $category, int $type, float $value, ?string $date, ?string $obs)
    {
        $movement = new Movement(category: $category, type: $type, value: $value, date: $date, obs: $obs, id: $id);
        $createdAt = new \DateTime();

        $expectedPayload = json_encode([
            'id' => $id,
            'category' => $category->jsonSerialize(),
            'type' => $type,
            'value' => $value,
            'date' => $date ?? date('Y-m-d H:i:s'),
            'obs' => $obs,
            'createdAt' => $createdAt->format('Y-m-d H:i:s'),
            'updatedAt' => $createdAt->format('Y-m-d H:i:s')
        ]);

        $this->assertEquals($expectedPayload, json_encode($movement));
    }
}
