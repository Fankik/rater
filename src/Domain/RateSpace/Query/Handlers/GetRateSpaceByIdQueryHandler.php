<?php

namespace Domain\RateSpace\Query\Handlers;

use Domain\RateSpace\Entity\RateSpace;
use Domain\RateSpace\Exceptions\RateSpaceNotFoundException;
use Domain\RateSpace\Query\GetRateSpaceByIdQuery;
use Domain\RateSpace\Repository\RateSpaceRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class GetRateSpaceByIdQueryHandler
{
    public function __construct(
        private RateSpaceRepositoryInterface $repository,
    ) {
    }

    public function __invoke(GetRateSpaceByIdQuery $query): RateSpace
    {
        $rateSpace = $this->repository->findById($query->id);

        if (!$rateSpace) {
            throw RateSpaceNotFoundException::withId($query->id);
        }

        return $rateSpace;
    }
}
