<?php

namespace Infrastructure\RateItem\Repository;

use Domain\RateItem\Entity\RateItem;
use Domain\RateItem\Repository\RateItemRepositoryInterface;
use Infrastructure\Helpers\Repository\AbstractRepositoryStub;
use Symfony\Component\Uid\Uuid;

final class RateItemRepositoryStub extends AbstractRepositoryStub implements RateItemRepositoryInterface
{
    public function save(RateItem $rateItem): void
    {
        $this->setExpected($rateItem);
    }

    /** @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter */
    public function findById(Uuid $id): ?RateItem
    {
        return $this->getExpected();
    }
}
