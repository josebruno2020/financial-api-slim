<?php

declare(strict_types=1);

namespace Tests\Application\Actions\Category;

use App\Domain\Category\Category;
use App\Domain\User\User;

trait CategoryActionTestHelper
{
    public function createCategoryMock(bool $withUser = false): Category
    {
        $user = null;
        if ($withUser) {
            $user = new User(email: 'teste@teste.com', name: 'Bruno', password: 'teste');
        }
        
        return new Category(
            name: 'Categoria 1',
            user: $user,
            id: 1
        );
    }
}