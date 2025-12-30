<?php

namespace Domain\User\Entity\ValueObjects;

enum UserRole: string
{
    case Admin = 'admin';

    /** @return array<string> */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
