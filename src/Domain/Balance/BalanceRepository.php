<?php

namespace App\Domain\Balance;

use App\Domain\Enums\MovementTypeEnum;

interface BalanceRepository
{
    public function getByUserId(int $userId): Balance;
    
    public function createBalance(int $userId): Balance;
    
    public function updateUserBalance(int $userId, float $newValue, MovementTypeEnum $type): void;
}