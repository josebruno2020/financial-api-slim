<?php

declare(strict_types=1);

namespace Tests\Domain\Balance;

use App\Domain\Balance\Balance;
use Tests\Application\Actions\User\UserActionTestHelper;
use Tests\TestCase;

class BalanceTest extends TestCase
{
    use UserActionTestHelper;
    public function testBalance()
    {
        $balance = new Balance(
            user: $this->createMockUser(),
            balance: 15.0,
        );
        
        var_dump($balance->jsonSerialize());
        exit();
    }
}