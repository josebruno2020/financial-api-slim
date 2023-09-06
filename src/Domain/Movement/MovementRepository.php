<?php

namespace App\Domain\Movement;

use App\Domain\Enums\MovementTypeEnum;
use JetBrains\PhpStorm\ArrayShape;

interface MovementRepository
{
    /**
     * @return Movement[] array
     */
    public function findAllInCurrentMonth(): array;

    /**
     * @return Movement[] array
     */
    public function findAll(): array;

    public function findMovementById(int $id): ?Movement;

    /**
     * @param array{user_id: int, category_id: int, value: float, date: ?string, type: int, obs: ?string} $data
     * @return Movement
     */
    public function createMovement(array $data): Movement;

    public function deleteMovementById(int $id): void;


    /**
     * @return array<string, float>
     */
    public function findTotalByTypeAndCategoryInMonth(string $month, MovementTypeEnum $type): array;
}