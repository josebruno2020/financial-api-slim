<?php

declare(strict_types=1);

namespace App\Domain\Helper;

class JsonSerializeHelper
{
    public static function toJson(array $objectValues): array
    {        
        array_walk_recursive($objectValues, function (&$property) {
            if (is_a($property, 'DateTime')) {
                $property = DateTimeHelper::formatDateTime($property);
            }
        });
        return $objectValues;
    }
}