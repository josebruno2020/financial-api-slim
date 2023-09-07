<?php

namespace App\Domain\Enums;

enum MovementStatusEnum: string
{
    case PAID = 'paid';
    case SCHEDULED = 'scheduled';
    case RECEIVED = 'received';

    public static function make(string $status): self
    {
        return match ($status)
        {
            'paid' => MovementStatusEnum::PAID,
            'scheduled' => MovementStatusEnum::SCHEDULED,
            'received' => MovementStatusEnum::RECEIVED
        };
    }
}