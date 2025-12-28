<?php

namespace Application\MessageBus\Stubs\Handlers;

use Application\MessageBus\Stubs\TestQueryStub;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class TestQueryHandlerStub
{
    /** @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter */
    public function __invoke(TestQueryStub $query): bool
    {
        return true;
    }
}
