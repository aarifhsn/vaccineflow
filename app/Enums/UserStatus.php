<?php

namespace App\Enums;

enum UserStatus: string
{
    case NOT_SCHEDULED = 'not scheduled';
    case SCHEDULED = 'scheduled';
    case VACCINATED = 'vaccinated';

    /**
     * Get all enum values.
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
