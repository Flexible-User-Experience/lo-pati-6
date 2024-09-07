<?php

namespace App\Enum;

final class PageTemplateTypeEnum
{
    public const int DEFAULT = 0;
    public const int MENU = 1;
    public const int SUBMENU = 2;
    public const int LIST = 3;
    public const int PAGE = 4;
    public const int BLOG = 5;
    public const int INFO = 6;

    // TODO fix required page templates
    public static function getTemplateTypeArray(): array
    {
        return [
            self::DEFAULT => 'default',
//            self::MENU => 'menu',
//            self::SUBMENU => 'submenu',
//            self::LIST => 'list',
//            self::PAGE => 'page',
            self::BLOG => 'blog',
            self::INFO => 'info',
        ];
    }

    // TODO fix required page templates
    public static function getEnumArray(): array
    {
        return [
            self::DEFAULT => 'enum.page_template_type.default',
//            self::MENU => 'enum.page_template_type.menu',
//            self::SUBMENU => 'enum.page_template_type.submenu',
//            self::LIST => 'enum.page_template_type.list',
//            self::PAGE => 'enum.page_template_type.page',
            self::BLOG => 'enum.page_template_type.blog',
            self::INFO => 'enum.page_template_type.info',
        ];
    }

    public static function getReversedEnumArray(): array
    {
        return array_flip(self::getEnumArray());
    }
}
