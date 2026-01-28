<?php

namespace Infrastructure\RateSpace\Repository;

use Domain\RateSpace\Entity\RateSpace;
use Domain\RateSpace\Repository\RateSpaceRepositoryInterface;
use Symfony\Component\Uid\Uuid;

final class TestRateSpaceRepository implements RateSpaceRepositoryInterface
{
    private bool $useRealRepository = true;

    public function __construct(
        private readonly RateSpaceRepositoryInterface $realRepository,
        private readonly RateSpaceRepositoryInterface $stubRepository,
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

    private function getProxiedRepository(): RateSpaceRepositoryInterface
    {
        return $this->useRealRepository ? $this->realRepository : $this->stubRepository;
    }

    public function save(RateSpace $rateSpace): void
    {
        $this->getProxiedRepository()->save($rateSpace);
    }

    public function findById(Uuid $id): ?RateSpace
    {
        return $this->getProxiedRepository()->findById($id);
    }

    public function findBySlug(string $slug): ?RateSpace
    {
        return $this->getProxiedRepository()->findBySlug($slug);
    }
}
