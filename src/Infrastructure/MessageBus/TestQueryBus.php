<?php

namespace Infrastructure\MessageBus;

use Domain\MessageBus\QueryBusInterface;
use Domain\MessageBus\QueryInterface;

final readonly class TestQueryBus implements QueryBusInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
    ) {
    }

    public function dispatch(QueryInterface $query): mixed
    {
        return $this->queryBus->dispatch($query);
    }
}
