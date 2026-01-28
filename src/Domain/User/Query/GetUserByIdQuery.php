<?php

namespace Domain\User\Query;

use Domain\MessageBus\QueryInterface;
use Symfony\Component\Uid\Uuid;

final class GetUserByIdQuery implements QueryInterface
{
    public function __construct(
        public Uuid $id,
    ) {
    }
}
