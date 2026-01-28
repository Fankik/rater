<?php

namespace Tests\Domain\RateSpace\Command\Handlers;

use Domain\RateSpace\Command\CreateRateSpaceCommand;
use Domain\RateSpace\Entity\RateSpace;
use Domain\RateSpace\Repository\RateSpaceRepositoryInterface;
use Infrastructure\RateSpace\Repository\RateSpaceRepository;
use Tests\Utils\Factory\User\UserFactory;
use Tests\Utils\TestCases\FunctionalTestCase;

final class CreateRateSpaceCommandHandlerTest extends FunctionalTestCase
{
    private RateSpaceRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->getServiceByClassName(RateSpaceRepository::class);
    }

    public function testRateSpaceMustBeCreate(): void
    {
        $user = UserFactory::createOne();

        $command = new CreateRateSpaceCommand(
            title: 'Title',
            description: 'Description',
            slug: 'slug',
            user: $user,
        );

        $this->getCommandBus()->dispatch($command);

        $findRateSpace = $this->repository->findBySlug($command->slug);

        self::assertInstanceOf(RateSpace::class, $findRateSpace);
        self::assertSame($command->slug, $findRateSpace->getSlug());
    }
}
