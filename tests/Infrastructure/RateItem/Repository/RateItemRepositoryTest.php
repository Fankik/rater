<?php

namespace Tests\Infrastructure\RateItem\Repository;

use Domain\RateItem\Entity\RateItem;
use Domain\RateItem\Repository\RateItemRepositoryInterface;
use Infrastructure\RateItem\Repository\RateItemRepository;
use Tests\Utils\Factory\RateItem\RateItemFactory;
use Tests\Utils\Factory\RateSpace\RateSpaceWithRandomUserFactory;
use Tests\Utils\Factory\User\UserFactory;
use Tests\Utils\TestCases\FunctionalTestCase;

final class RateItemRepositoryTest extends FunctionalTestCase
{
    private RateItemRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->getServiceByClassName(RateItemRepository::class);
    }

    public function testRateItemMustBeSave(): void
    {
        $user = UserFactory::createOne();
        $rateSpace = RateSpaceWithRandomUserFactory::createOne();

        $rateItem = new RateItem(
            title: 'Title',
            description: 'Description',
            score: 2.3,
            rateSpace: $rateSpace,
            user: $user,
        );

        $this->repository->save($rateItem);

        $findRateItem = $this->repository->findById($rateItem->getId());

        assert($findRateItem instanceof RateItem);

        self::assertTrue($rateItem->getId()->equals($findRateItem->getId()));
        self::assertTrue($rateItem->getUser()->getId()->equals($findRateItem->getUser()->getId()));
        self::assertTrue($rateItem->getRateSpace()->getId()->equals($findRateItem->getRateSpace()->getId()));
        self::assertSame($rateItem->getTitle(), $findRateItem->getTitle());
        self::assertSame($rateItem->getDescription(), $findRateItem->getDescription());
        self::assertSame($rateItem->getScore(), $findRateItem->getScore());
    }

    public function testRateItemMustFindById(): void
    {
        $rateSpace = RateItemFactory::createOne();

        $findRateItem = $this->repository->findById($rateSpace->getId());

        self::assertInstanceOf(RateItem::class, $findRateItem);
        self::assertTrue($rateSpace->getId()->equals($findRateItem->getId()));
    }
}
