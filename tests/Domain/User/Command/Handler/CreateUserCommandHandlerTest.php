<?php

namespace Tests\Domain\User\Command\Handler;

use Domain\User\Command\CreateUserCommand;
use Domain\User\Entity\ValueObjects\UserRoles;
use Tests\Utils\TestCases\FunctionalTestCase;

final class CreateUserCommandHandlerTest extends FunctionalTestCase
{
    public function testUserMustBeCreate(): void
    {
        $command = new CreateUserCommand(
            name: 'user name',
            email: 'user email',
            roles: UserRoles::fromArray([]),
            hashedPassword: 'hashed password',
        );

        $commandBus = $this->getCommandBus();

        $commandBus->dispatch($command);

        $commandBus->assertIsDispatch(CreateUserCommand::class);
    }
}
