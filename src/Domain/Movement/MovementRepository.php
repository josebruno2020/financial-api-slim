<?php

namespace App\Domain\Movement;

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
}