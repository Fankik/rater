<?php

namespace Domain\MessageBus;

use Throwable;

interface QueryBusInterface
{
    /** @throws Throwable */
    public function dispatch(QueryInterface $query): mixed;
}
