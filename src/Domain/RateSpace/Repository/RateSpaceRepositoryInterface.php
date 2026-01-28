<?php

namespace Domain\RateSpace\Repository;

use Domain\RateSpace\Entity\RateSpace;
use Symfony\Component\Uid\Uuid;

interface RateSpaceRepositoryInterface
{
    public function save(RateSpace $rateSpace): void;

    public function findById(Uuid $id): ?RateSpace;

    public function findBySlug(string $slug): ?RateSpace;
}
