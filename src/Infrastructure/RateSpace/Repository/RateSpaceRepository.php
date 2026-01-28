<?php

namespace Infrastructure\RateSpace\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Domain\RateSpace\Entity\RateSpace;
use Domain\RateSpace\Repository\RateSpaceRepositoryInterface;
use Symfony\Component\Uid\Uuid;

final readonly class RateSpaceRepository implements RateSpaceRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function save(RateSpace $rateSpace): void
    {
        $this->entityManager->persist($rateSpace);
        $this->entityManager->flush();
    }

    public function findById(Uuid $id): ?RateSpace
    {
        return $this->entityManager->getRepository(RateSpace::class)->find($id);
    }

    public function findBySlug(string $slug): ?RateSpace
    {
        return $this->entityManager->getRepository(RateSpace::class)->findOneBy(['slug' => $slug]);
    }
}
