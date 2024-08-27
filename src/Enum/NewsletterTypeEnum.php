<?php

namespace App\Enum;

final class NewsletterTypeEnum
{
    public const int NEWS = 0;
    public const int EVENTS = 1;
    public const int EXPOSITIONS = 2;
    public const int RECOMMENDATIONS = 3;

    public static function getEnumArray(): array
    {
        return [
            self::NEWS => 'enum.newsletter_type.news',
            self::EVENTS => 'enum.newsletter_type.events',
            self::EXPOSITIONS => 'enum.newsletter_type.expositions',
            self::RECOMMENDATIONS => 'enum.newsletter_type.recommendations',
        ];
    }

    public static function getReversedEnumArray(): array
    {
        return array_flip(self::getEnumArray());
    }
}
