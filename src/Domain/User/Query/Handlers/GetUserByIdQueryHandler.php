<?php

namespace Domain\User\Query\Handlers;

use Domain\User\Entity\User;
use Domain\User\Exceptions\UserNotFoundException;
use Domain\User\Query\GetUserByIdQuery;
use Domain\User\Repository\UserRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class GetUserByIdQueryHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {
    }

    public function __invoke(GetUserByIdQuery $query): User
    {
        $user = $this->userRepository->findById($query->id);

        if (!$user instanceof User) {
            throw UserNotFoundException::withId($query->id);
        }

        return $user;
    }
}
