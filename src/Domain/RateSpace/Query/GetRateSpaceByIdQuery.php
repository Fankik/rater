<?php

namespace Domain\RateSpace\Query;

use Domain\MessageBus\QueryInterface;
use Symfony\Component\Uid\Uuid;

final class GetRateSpaceByIdQuery implements QueryInterface
{
    public function __construct(
        public Uuid $id,
    ) {
    }
}
