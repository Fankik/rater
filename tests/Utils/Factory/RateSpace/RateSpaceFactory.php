<?php

namespace Tests\Utils\Factory\RateSpace;

use Domain\RateSpace\Entity\RateSpace;
use Domain\RateSpace\Entity\ValueObjects\RateSpaceVisibleType;
use Zenstruck\Foundry\Persistence\PersistentObjectFactory;

/**
 * @abstract
 *
 * @extends PersistentObjectFactory<RateSpace>
 */
class RateSpaceFactory extends PersistentObjectFactory
{
    /** @return array<string, mixed> */
    protected function defaults(): array
    {
        return [
            'title' => self::faker()->name(),
            'description' => self::faker()->text(),
            'slug' => self::faker()->slug(),
            'visibleType' => RateSpaceVisibleType::Public,
        ];
    }

    public static function class(): string
    {
        return RateSpace::class;
    }
}
