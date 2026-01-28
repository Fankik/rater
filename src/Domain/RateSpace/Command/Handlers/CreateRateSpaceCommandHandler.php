<?php

namespace Domain\RateSpace\Command\Handlers;

use Domain\RateSpace\Command\CreateRateSpaceCommand;
use Domain\RateSpace\Entity\RateSpace;
use Domain\RateSpace\Repository\RateSpaceRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class CreateRateSpaceCommandHandler
{
    public function __construct(
        private RateSpaceRepositoryInterface $rateSpaceRepository,
    ) {
    }

    public function __invoke(CreateRateSpaceCommand $command): void
    {
        $rateSpace = new RateSpace(
            title: $command->title,
            description: $command->description,
            slug: $command->slug,
            user: $command->user,
        );

        $this->rateSpaceRepository->save($rateSpace);
    }
}
