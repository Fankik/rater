<?php

namespace Domain\User\Command;

use Domain\MessageBus\CommandInterface;
use Domain\User\Entity\ValueObjects\UserRoles;
use Symfony\Component\Uid\Uuid;

final class CreateUserCommand implements CommandInterface
{
    public function __construct(
        public string $name,
        public string $email,
        public UserRoles $roles,
        public string $hashedPassword,
        public ?Uuid $id = null,
    ) {
    }
}
