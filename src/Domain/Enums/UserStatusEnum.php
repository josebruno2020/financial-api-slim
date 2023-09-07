<?php

namespace App\Domain\Enums;

enum UserStatusEnum: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    
    public static function make(string $status): self
    {
        return match ($status)
        {
            'active' => UserStatusEnum::ACTIVE,
            'inactive' => UserStatusEnum::INACTIVE
        };
    }
}