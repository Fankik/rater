<?php

namespace Infrastructure\RateItem\Repository;

use Domain\RateItem\Repository\RateItemRepositoryInterface;
use Domain\RateItem\Entity\RateItem;
use Symfony\Component\Uid\Uuid;

final class TestRateItemRepository implements RateItemRepositoryInterface
{
    private bool $useRealRepository = true;

    public function __construct(
        private readonly RateItemRepositoryInterface $realRepository,
        private readonly RateItemRepositoryInterface $stubRepository,
    ) {
    }

    public function useReal(): void
    {
        $this->useRealRepository = true;
    }

    public function useStub(): void
    {
        $this->useRealRepository = false;
    }

    private function getProxiedRepository(): RateItemRepositoryInterface
    {
        return $this->useRealRepository ? $this->realRepository : $this->stubRepository;
    }

    public function save(RateItem $rateItem): void
    {
        $this->getProxiedRepository()->save($rateItem);
    }

    public function findById(Uuid $id): ?RateItem
    {
        return $this->getProxiedRepository()->findById($id);
    }
}
