<?php

namespace Domain\RateSpace\Command;

use Domain\MessageBus\CommandInterface;
use Domain\User\Entity\User;

final class CreateRateSpaceCommand implements CommandInterface
{
    public function __construct(
        public string $title,
        public string $description,
        public string $slug,
        public User $user,
    ) {
    }
}
