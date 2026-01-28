<?php

namespace Tests\Infrastructure\RateSpace\Repository;

use Domain\RateSpace\Entity\RateSpace;
use Domain\RateSpace\Repository\RateSpaceRepositoryInterface;
use Infrastructure\RateSpace\Repository\RateSpaceRepository;
use Tests\Utils\Factory\RateSpace\RateSpaceWithRandomUserFactory;
use Tests\Utils\Factory\User\UserFactory;
use Tests\Utils\TestCases\FunctionalTestCase;

final class RateSpaceRepositoryTest extends FunctionalTestCase
{
    private RateSpaceRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->getServiceByClassName(RateSpaceRepository::class);
    }

    public function testRateSpaceMustBeSave(): void
    {
        $user = UserFactory::createOne();

        $rateSpace = new RateSpace(
            title: 'Title',
            description: 'Description',
            slug: 'slug',
            user: $user,
        );

        $this->repository->save($rateSpace);

        $findRateSpace = $this->repository->findById($rateSpace->getId());

        assert($findRateSpace instanceof RateSpace);

        self::assertTrue($rateSpace->getId()->equals($findRateSpace->getId()));
        self::assertTrue($rateSpace->getUser()->getId()->equals($findRateSpace->getUser()->getId()));
        self::assertSame($rateSpace->getTitle(), $findRateSpace->getTitle());
        self::assertSame($rateSpace->getDescription(), $findRateSpace->getDescription());
        self::assertSame($rateSpace->getSlug(), $findRateSpace->getSlug());
    }

    public function testRateSpaceMustFindById(): void
    {
        $rateSpace = RateSpaceWithRandomUserFactory::createOne();

        $findRateSpace = $this->repository->findById($rateSpace->getId());

        self::assertInstanceOf(RateSpace::class, $findRateSpace);
        self::assertTrue($rateSpace->getId()->equals($findRateSpace->getId()));
    }

    public function testRateSpaceMustFindBySlug(): void
    {
        $rateSpace = RateSpaceWithRandomUserFactory::createOne();

        $findRateSpace = $this->repository->findBySlug($rateSpace->getSlug());

        self::assertInstanceOf(RateSpace::class, $findRateSpace);
        self::assertTrue($rateSpace->getId()->equals($findRateSpace->getId()));
    }
}
