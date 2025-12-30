<?php

namespace Tests\Utils\Factory\User;

use Domain\User\Entity\User;
use Domain\User\Entity\ValueObjects\UserRole;
use Domain\User\Entity\ValueObjects\UserRoles;
use Zenstruck\Foundry\Persistence\PersistentObjectFactory;

/**
 * @extends PersistentObjectFactory<User>
 */
final class UserFactory extends PersistentObjectFactory
{
    /** @return array<string, mixed> */
    protected function defaults(): array
    {
        return [
            'name' => self::faker()->name(),
            'email' => self::faker()->email(),
            'hashedPassword' => self::faker()->password(),
            'roles' => UserRoles::fromArray([UserRole::Admin->value]),
        ];
    }

    public static function class(): string
    {
        return User::class;
    }
}
