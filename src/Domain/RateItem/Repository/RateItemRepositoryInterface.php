<?php

namespace Domain\RateItem\Repository;

use Domain\RateItem\Entity\RateItem;
use Symfony\Component\Uid\Uuid;

interface RateItemRepositoryInterface
{
    public function save(RateItem $rateItem): void;

    public function findById(Uuid $id): ?RateItem;
}
