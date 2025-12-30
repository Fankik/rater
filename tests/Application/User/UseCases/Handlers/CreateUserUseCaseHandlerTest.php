<?php

namespace Tests\Application\User\UseCases\Handlers;

use Application\User\UseCases\CreateUserUseCase;
use Domain\User\Command\CreateUserCommand;
use Domain\User\Entity\ValueObjects\UserRole;
use Tests\Utils\TestCases\FunctionalTestCase;

final class CreateUserUseCaseHandlerTest extends FunctionalTestCase
{
    public function testUseCaseMustBeHandle(): void
    {
        $commandBus = $this->getCommandBus();

        $useCase = self::buildUseCase();

        $commandBus->dispatch($useCase);

        $commandBus->assertIsDispatch(CreateUserCommand::class);
    }

    private static function buildUseCase(): CreateUserUseCase
    {
        $useCase = new CreateUserUseCase();

        $useCase->name = 'test name';
        $useCase->email = 'test@test.email';
        $useCase->password = 'test password';
        $useCase->roles = [
            UserRole::Admin->value,
        ];

        return $useCase;
    }
}
