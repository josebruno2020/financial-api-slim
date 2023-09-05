<?php

namespace App\Domain\Enums;

enum MovementTypeEnum: int
{
    case INFLOW = 0;
    case OUTFLOW = 1;
}