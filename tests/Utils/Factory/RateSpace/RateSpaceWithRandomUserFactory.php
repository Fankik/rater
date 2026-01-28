<?php

namespace Tests\Utils\Factory\RateSpace;

use Tests\Utils\Factory\User\UserFactory;

final class RateSpaceWithRandomUserFactory extends RateSpaceFactory
{
    /** @return array<string, mixed> */
    protected function defaults(): array
    {
        $defaults = parent::defaults();

        $defaults['user'] = UserFactory::createOne();

        return $defaults;
    }
}
