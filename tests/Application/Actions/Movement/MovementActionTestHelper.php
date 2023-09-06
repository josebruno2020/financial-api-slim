<?php

namespace Tests\Application\Actions\Movement;

use App\Domain\Category\Category;
use App\Domain\Movement\Movement;

trait MovementActionTestHelper
{
    public function createMockMovement(): Movement
    {
        return new Movement(
            category: new Category(id: 1, name: 'Categoria 1'),
            type: 0,
            value: 50.0,
            date: date('Y-m-d'),
            obs: 'Legal',
            id: 1
        );
    }
}