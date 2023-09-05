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
}