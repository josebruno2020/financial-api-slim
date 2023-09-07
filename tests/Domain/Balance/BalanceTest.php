<?php

declare(strict_types=1);

namespace Tests\Domain\Balance;

use App\Domain\Balance\Balance;
use App\Domain\User\User;
use Tests\Application\Actions\User\UserActionTestHelper;
use Tests\TestCase;

class BalanceTest extends TestCase
{
    use UserActionTestHelper;

    public function balanceProvider(): array
    {
        return [
            [$this->createMockUser(), 50.0, 1]
        ];
    }

    /**
     * @dataProvider balanceProvider
     * @param User $user
     * @param float $value
     * @param int $id
     */
    public function testGetters(User $user, float $value, int $id)
    {
        $balance = new Balance(user: $user, balance: $value, id: $id);
        $createdAt = new \DateTime();

        $this->assertEquals($id, $balance->getId());
        $this->assertEquals($value, $balance->getBalance());
        $this->assertEquals($createdAt->format('Y-m-d H:i:s'), $balance->getCreatedAt());
    }
}