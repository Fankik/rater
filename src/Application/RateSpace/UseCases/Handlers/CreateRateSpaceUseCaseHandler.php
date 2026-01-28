<?php

namespace Application\RateSpace\UseCases\Handlers;

use Application\Helpers\Slug\SlugGenerator;
use Application\RateSpace\UseCases\CreateRateSpaceUseCase;
use Domain\MessageBus\CommandBusInterface;
use Domain\MessageBus\CommandInterface;
use Domain\MessageBus\QueryBusInterface;
use Domain\RateSpace\Command\CreateRateSpaceCommand;
use Domain\RateSpace\Entity\RateSpace;
use Domain\User\Entity\User;
use Domain\User\Query\GetUserByIdQuery;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Uid\Uuid;

#[AsMessageHandler]
final readonly class CreateRateSpaceUseCaseHandler implements CommandInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus,
        private SlugGenerator $slugGenerator,
    ) {
    }

    public function __invoke(CreateRateSpaceUseCase $useCase): void
    {
        $command = new CreateRateSpaceCommand(
            title: $useCase->title,
            description: $useCase->description,
            slug: $useCase->slug ?? $this->generateSlug(),
            user: $this->getUserById($useCase->userId),
        );

        $this->commandBus->dispatch($command);
    }

    private function generateSlug(): string
    {
        return $this->slugGenerator->generateUniqueSlug(RateSpace::class);
    }

    private function getUserById(string $userId): User
    {
        $query = new GetUserByIdQuery(
            id: Uuid::fromString($userId),
        );

        return $this->queryBus->dispatch($query);
    }
}
