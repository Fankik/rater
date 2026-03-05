<?php

namespace Domain\RateItem\Command;

use Domain\MessageBus\CommandInterface;
use Domain\RateSpace\Entity\RateSpace;
use Domain\User\Entity\User;
use Symfony\Component\Uid\Uuid;

final class CreateRateItemCommand implements CommandInterface
{
    public function __construct(
        public string $title,
        public string $description,
        public float $score,
        public RateSpace $rateSpace,
        public User $user,
        public ?Uuid $id = null,
    ) {
    }
}
