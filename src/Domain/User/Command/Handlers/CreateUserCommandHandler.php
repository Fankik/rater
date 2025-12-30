<?php

namespace Domain\User\Command\Handlers;

use Domain\User\Command\CreateUserCommand;
use Domain\User\Entity\User;
use Domain\User\Repository\UserRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class CreateUserCommandHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {
    }

    public function __invoke(CreateUserCommand $command): void
    {
        $user = new User(
            name: $command->name,
            email: $command->email,
            roles: $command->roles,
            hashedPassword: $command->hashedPassword,
            id: $command->id,
        );

        $this->userRepository->save($user);
    }
}
