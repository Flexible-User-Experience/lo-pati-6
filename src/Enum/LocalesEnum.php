<?php

namespace App\Enum;

class LocalesEnum
{
    public const string CA = 'ca';
    public const string ES = 'es';

    public static function getLocalesArray(): array
    {
        return [
          self::CA,
          self::ES,
        ];
    }
}
