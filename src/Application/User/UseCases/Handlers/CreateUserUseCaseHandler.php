<?php

namespace Application\User\UseCases\Handlers;

use Application\Security\PasswordHasher\PasswordHasherInterface;
use Application\User\UseCases\CreateUserUseCase;
use Domain\MessageBus\CommandBusInterface;
use Domain\User\Command\CreateUserCommand;
use Domain\User\Entity\ValueObjects\UserRoles;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class CreateUserUseCaseHandler
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private PasswordHasherInterface $passwordHasher,
    ) {
    }

    public function __invoke(CreateUserUseCase $useCase): void
    {
        $command = new CreateUserCommand(
            name: $useCase->name,
            email: $useCase->email,
            roles: UserRoles::fromArray($useCase->roles),
            hashedPassword: $this->passwordHasher->hash($useCase->password),
            id: $useCase->id,
        );

        $this->commandBus->dispatch($command);
    }
}
