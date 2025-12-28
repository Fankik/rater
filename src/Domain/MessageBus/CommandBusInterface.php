<?php

namespace Domain\MessageBus;

interface CommandBusInterface
{
    /** @throws \Throwable */
    public function dispatch(CommandInterface $command): void;
}
