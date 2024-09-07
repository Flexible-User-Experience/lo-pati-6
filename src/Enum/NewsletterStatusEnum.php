<?php

namespace App\Enum;

final class NewsletterStatusEnum
{
    public const int WAITING = 0;
    public const int SENDING = 1;
    public const int SENT = 2;

    public static function getEnumArray(): array
    {
        return [
            self::WAITING => 'enum.newsletter_status.waiting',
            self::SENDING => 'enum.newsletter_status.sending',
            self::SENT => 'enum.newsletter_status.sent',
        ];
    }

    public static function getReversedEnumArray(): array
    {
        return array_flip(self::getEnumArray());
    }
}
