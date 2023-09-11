<?php

declare(strict_types=1);

namespace App\Domain\Movement;

use App\Domain\Enums\MovementTypeEnum;

interface MovementGroupRepository
{
    /**
     * @return Movement[] array
     */
    public function findAllInMonth(int $groupId, string $month, ?int $categoryId = null, ?MovementTypeEnum $type = null): array;
    
    public function findTotalByTypeAndCategoryInMonth(int $groupId, string $month, MovementTypeEnum $type): array;
    
    public function findTotalTypeInMonth(int $groupId, string $month): array;

    public function findTotalStatusInMonth(int $groupId, string $month): array;
}