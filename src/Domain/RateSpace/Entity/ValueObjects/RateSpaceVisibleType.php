<?php

namespace Domain\RateSpace\Entity\ValueObjects;

enum RateSpaceVisibleType: string
{
    case Public = 'public';

    case Private = 'private';

    case PublicReadOnly = 'public-read-only';

    /** @return array<string> */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
