<?php

namespace Infrastructure\RateSpace\Repository;

use Domain\RateSpace\Entity\RateSpace;
use Domain\RateSpace\Repository\RateSpaceRepositoryInterface;
use Infrastructure\Helpers\Repository\AbstractRepositoryStub;
use Symfony\Component\Uid\Uuid;

final class RateSpaceRepositoryStub extends AbstractRepositoryStub implements RateSpaceRepositoryInterface
{
    public function save(RateSpace $rateSpace): void
    {
        $this->setExpected($rateSpace);
    }

    /** @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter */
    public function findById(Uuid $id): ?RateSpace
    {
        return $this->getExpected();
    }

    /** @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter */
    public function findBySlug(string $slug): ?RateSpace
    {
        return $this->getExpected();
    }
}
