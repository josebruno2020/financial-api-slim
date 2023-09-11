<?php

namespace App\Domain\Movement;

use App\Domain\Enums\MovementTypeEnum;
use JetBrains\PhpStorm\ArrayShape;

interface MovementRepository
{
    /**
     * @return Movement[] array
     */
    public function findAllInMonth(int $userId, string $month, ?int $categoryId = null, ?MovementTypeEnum $type = null): array;

    /**
     * @return Movement[] array
     */
    public function findAll(int $userId): array;

    public function findMovementById(int $id): ?Movement;

    /**
     * @param array{user_id: int, category_id: int, value: float, payment_form_id: int, date: ?string, type: int, userId: int, obs: ?string, group_id: ?int} $data
     * @return Movement
     */
    public function createMovement(array $data): Movement;

    public function deleteMovementById(int $id, int $userId): void;


    /**
     * @return array<string, float>
     */
    public function findTotalByTypeAndCategoryInMonth(string $month, MovementTypeEnum $type, int $userId): array;

    public function findTotalTypeInMonth(string $month, int $userId): array;

    public function findTotalStatusInMonth(string $month, int $userId): array;
}