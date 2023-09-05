<?php

declare(strict_types=1);

namespace App\Domain\Helper;

class DateTimeHelper
{
    public static function formatDateTime(?\DateTime $dateTime): ?string
    {
        return $dateTime?->format('Y-m-d H:i:s') ?? null;
    }
}