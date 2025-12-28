<?php

namespace Tests\Application\MessageBus;

use Application\MessageBus\Stubs\TestQueryStub;
use Symfony\Component\Messenger\Exception\ValidationFailedException;
use Tests\Utils\TestCases\FunctionalTestCase;

final class QueryBusTest extends FunctionalTestCase
{
    public function testQueryMustBeDispatched(): void
    {
        $queryBus = $this->getQueryBus();

        $result = $queryBus->dispatch(new TestQueryStub());

        self::assertTrue($result);
    }

    public function testQueryMustNotBeDispatched(): void
    {
        $this->expectException(ValidationFailedException::class);

        $queryBus = $this->getQueryBus();

        $command = new TestQueryStub();
        $command->string = '';

        $queryBus->dispatch($command);
    }
}
