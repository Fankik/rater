<?php

namespace Infrastructure\MessageBus;

use Domain\MessageBus\CommandBusInterface;
use Domain\MessageBus\CommandInterface;
use PHPUnit\Framework\Assert;

final class TestCommandBus implements CommandBusInterface
{
    /** @var array<int, object> */
    private array $dispatchedCommands = [];

    public function __construct(
        private readonly CommandBusInterface $commandBus,
    ) {
    }

    public function dispatch(CommandInterface $command): void
    {
        $this->commandBus->dispatch($command);

        $this->dispatchedCommands[] = $command;
    }

    /**
     * @param class-string<CommandInterface> $commandClassName
     */
    public function assertIsDispatch(string $commandClassName): void
    {
        foreach ($this->dispatchedCommands as $dispatchedCommand) {
            if ($dispatchedCommand instanceof $commandClassName) {
                Assert::assertInstanceOf($commandClassName, $dispatchedCommand);

                return;
            }
        }

        Assert::fail(sprintf('Command %s was not dispatched', $commandClassName));
    }
}
