<?php

namespace App\Enum;

final class MonthEnum
{
    public const int JANUARY = 1;
    public const int FEBRUARY = 2;
    public const int MARCH = 3;
    public const int APRIL = 4;
    public const int MAY = 5;
    public const int JUNE = 6;
    public const int JULY = 7;
    public const int AUGUST = 8;
    public const int SEPTEMBER = 9;
    public const int OCTOBER = 10;
    public const int NOVEMBER = 11;
    public const int DECEMBER = 12;

    public static function getEnumArray(): array
    {
        return [
            self::JANUARY => 'enum.month.january',
            self::FEBRUARY => 'enum.month.febraury',
            self::MARCH => 'enum.month.march',
            self::APRIL => 'enum.month.april',
            self::MAY => 'enum.month.may',
            self::JUNE => 'enum.month.june',
            self::JULY => 'enum.month.july',
            self::AUGUST => 'enum.month.august',
            self::SEPTEMBER => 'enum.month.september',
            self::OCTOBER => 'enum.month.october',
            self::NOVEMBER => 'enum.month.november',
            self::DECEMBER => 'enum.month.december',
        ];
    }

    public static function getReversedEnumArray(): array
    {
        return array_flip(self::getEnumArray());
    }
}
