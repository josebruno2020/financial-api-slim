<?php

namespace App\Domain\Enums;

enum MovementTypeEnum: int
{
    case INFLOW = 0;
    case OUTFLOW = 1;

    public static function make(int $type): self
    {
        return match ($type)
        {
            0 => MovementTypeEnum::INFLOW,
            1 => MovementTypeEnum::OUTFLOW
        };
    }
}