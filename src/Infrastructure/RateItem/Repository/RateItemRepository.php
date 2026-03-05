<?php

namespace Infrastructure\RateItem\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Domain\RateItem\Entity\RateItem;
use Domain\RateItem\Repository\RateItemRepositoryInterface;
use Symfony\Component\Uid\Uuid;

final readonly class RateItemRepository implements RateItemRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function save(RateItem $rateItem): void
    {
        $this->entityManager->persist($rateItem);
        $this->entityManager->flush();
    }

    public function findById(Uuid $id): ?RateItem
    {
        return $this->entityManager->getRepository(RateItem::class)->find($id);
    }
}
