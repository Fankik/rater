<?php

namespace Application\MessageBus\Stubs\Handlers;

use Application\MessageBus\Stubs\TestCommandStub;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class TestCommandHandlerStub
{
    /** @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter */
    public function __invoke(TestCommandStub $command): void
    {
        // TODO: Implement __invoke() method.
    }
}
