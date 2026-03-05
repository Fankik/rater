<?php

namespace Application\RateItem\UseCase\Handlers;

use Application\RateItem\UseCase\CreateRateItemUseCase;
use Domain\MessageBus\CommandBusInterface;
use Domain\MessageBus\CommandInterface;
use Domain\MessageBus\QueryBusInterface;
use Domain\RateItem\Command\CreateRateItemCommand;
use Domain\RateSpace\Entity\RateSpace;
use Domain\RateSpace\Query\GetRateSpaceByIdQuery;
use Domain\User\Entity\User;
use Domain\User\Query\GetUserByIdQuery;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Uid\Uuid;

#[AsMessageHandler]
final readonly class CreateRateItemUseCaseHandler implements CommandInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus,
    ) {
    }

    public function __invoke(CreateRateItemUseCase $useCase): void
    {
        $command = new CreateRateItemCommand(
            title: $useCase->title,
            description: $useCase->description,
            score: $useCase->score,
            rateSpace: $this->getRateSpaceById($useCase->rateSpaceId),
            user: $this->getUserById($useCase->userId),
        );

        $this->commandBus->dispatch($command);
    }

    private function getRateSpaceById(string $rateSpaceId): RateSpace
    {
        $query = new GetRateSpaceByIdQuery(
            id: Uuid::fromString($rateSpaceId),
        );

        return $this->queryBus->dispatch($query);
    }

    private function getUserById(string $userId): User
    {
        $query = new GetUserByIdQuery(
            id: Uuid::fromString($userId),
        );

        return $this->queryBus->dispatch($query);
    }
}
