<?php

namespace Tests\Domain\RateItem\Command\Handlers;

use Domain\RateItem\Command\CreateRateItemCommand;
use Domain\RateItem\Entity\RateItem;
use Domain\RateItem\Repository\RateItemRepositoryInterface;
use Infrastructure\RateItem\Repository\RateItemRepository;
use Symfony\Component\Uid\Uuid;
use Tests\Utils\Factory\RateSpace\RateSpaceWithRandomUserFactory;
use Tests\Utils\Factory\User\UserFactory;
use Tests\Utils\TestCases\FunctionalTestCase;

final class CreateRateItemCommandHandlerTest extends FunctionalTestCase
{
    private RateItemRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->getServiceByClassName(RateItemRepository::class);
    }

    public function testRateItemMustBeCreate(): void
    {
        $id = Uuid::v7();
        $user = UserFactory::createOne();
        $rateSpace = RateSpaceWithRandomUserFactory::createOne();

        $command = new CreateRateItemCommand(
            title: 'Title',
            description: 'Description',
            score: 5,
            rateSpace: $rateSpace,
            user: $user,
            id: $id,
        );

        $this->getCommandBus()->dispatch($command);

        $findRateItem = $this->repository->findById($id);

        self::assertInstanceOf(RateItem::class, $findRateItem);
        self::assertTrue($command->id?->equals($findRateItem->getId()));
    }
}
