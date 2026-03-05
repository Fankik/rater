<?php

namespace Domain\RateItem\Command\Handlers;

use Domain\RateItem\Command\CreateRateItemCommand;
use Domain\RateItem\Entity\RateItem;
use Domain\RateItem\Repository\RateItemRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class CreateRateItemCommandHandler
{
    public function __construct(
        private RateItemRepositoryInterface $rateItemRepository,
    ) {
    }

    public function __invoke(CreateRateItemCommand $command): void
    {
        $rateItem = new RateItem(
            title: $command->title,
            description: $command->description,
            score: $command->score,
            rateSpace: $command->rateSpace,
            user: $command->user,
            id: $command->id ?? null,
        );

        $this->rateItemRepository->save($rateItem);
    }
}
