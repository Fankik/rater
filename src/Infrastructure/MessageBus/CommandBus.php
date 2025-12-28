<?php

namespace Infrastructure\MessageBus;

use Domain\MessageBus\CommandBusInterface;
use Domain\MessageBus\CommandInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class CommandBus implements CommandBusInterface
{
    use HandleTrait;

    public function __construct(
        readonly MessageBusInterface $commandBus,
    ) {
        $this->messageBus = $commandBus;
    }

    public function dispatch(CommandInterface $command): void
    {
        try {
            $this->handle($command);
        } catch (HandlerFailedException $handlerFailedException) {
            if ($handlerFailedException->getPrevious() instanceof \Throwable) {
                throw $handlerFailedException->getPrevious();
            }

            throw $handlerFailedException;
        }
    }
}
