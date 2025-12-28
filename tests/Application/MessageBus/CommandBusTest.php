<?php

namespace Tests\Application\MessageBus;

use Application\MessageBus\Stubs\TestCommandStub;
use Symfony\Component\Messenger\Exception\ValidationFailedException;
use Tests\Utils\TestCases\FunctionalTestCase;

final class CommandBusTest extends FunctionalTestCase
{
    public function testCommandMustBeDispatched(): void
    {
        $commandBus = $this->getCommandBus();

        $commandBus->dispatch(new TestCommandStub());

        $commandBus->assertIsDispatch(TestCommandStub::class);
    }

    public function testCommandMustNotBeDispatched(): void
    {
        $this->expectException(ValidationFailedException::class);

        $commandBus = $this->getCommandBus();

        $command = new TestCommandStub();
        $command->string = '';

        $commandBus->dispatch($command);
    }
}
