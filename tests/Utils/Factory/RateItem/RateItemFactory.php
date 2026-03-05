<?php

namespace Tests\Utils\Factory\RateItem;

use Domain\RateItem\Entity\RateItem;
use Tests\Utils\Factory\RateSpace\RateSpaceWithRandomUserFactory;
use Tests\Utils\Factory\User\UserFactory;
use Zenstruck\Foundry\Persistence\PersistentObjectFactory;

/**
 * @abstract
 *
 * @extends PersistentObjectFactory<RateItem>
 */
class RateItemFactory extends PersistentObjectFactory
{
    /** @return array<string, mixed> */
    protected function defaults(): array
    {
        $user = UserFactory::createOne();
        $rateSpace = RateSpaceWithRandomUserFactory::createOne();

        return [
            'title' => self::faker()->name(),
            'description' => self::faker()->text(),
            'score' => self::faker()->randomFloat(),
            'rateSpace' => $rateSpace,
            'user' => $user,
        ];
    }

    public static function class(): string
    {
        return RateItem::class;
    }
}
