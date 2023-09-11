<?php

namespace Tests\Application\Actions\Movement;

use App\Domain\Category\Category;
use App\Domain\Movement\Movement;
use App\Domain\PaymentForm\PaymentForm;

trait MovementActionTestHelper
{
    public function createMockMovement(): Movement
    {
        return new Movement(
            category: new Category(name: 'Categoria 1', id: 1),
            type: 0,
            value: 50.0,
            paymentForm: new PaymentForm(name: 'PIX', id: 1),
            date: date('Y-m-d'),
            obs: 'Legal',
            id: 1
        );
    }
}