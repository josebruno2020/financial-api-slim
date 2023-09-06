<?php

declare(strict_types=1);

namespace Tests\Application\Actions\User;

use App\Domain\User\User;

trait UserActionTestHelper
{
    public function createMockUser(): User
    {
        return new User(
            email: 'teste@email.com',
            name: 'Teste',
            password: '123123',
            id: 1
        );
    }
}