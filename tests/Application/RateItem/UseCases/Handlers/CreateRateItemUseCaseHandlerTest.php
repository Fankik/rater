<?php

namespace Tests\Application\RateItem\UseCases\Handlers;

use Application\RateItem\UseCase\CreateRateItemUseCase;
use Domain\RateItem\Command\CreateRateItemCommand;
use Faker\Factory;
use Faker\Generator;
use Tests\Utils\Factory\RateSpace\RateSpaceWithRandomUserFactory;
use Tests\Utils\Factory\User\UserFactory;
use Tests\Utils\TestCases\FunctionalTestCase;

final class CreateRateItemUseCaseHandlerTest extends FunctionalTestCase
{
    private Generator $faker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();
    }

    public function testRateSpaceMustBeCreate(): void
    {
        $useCase = $this->buildUseCase();

        $this->getCommandBus()->dispatch($useCase);

        $this->getCommandBus()->assertIsDispatch(CreateRateItemUseCase::class);
        $this->getCommandBus()->assertIsDispatch(CreateRateItemCommand::class);
    }

    private function buildUseCase(): CreateRateItemUseCase
    {
        $user = UserFactory::createOne();
        $rateSpace = RateSpaceWithRandomUserFactory::createOne();

        $useCase = new CreateRateItemUseCase();

        $useCase->title = 'title';
        $useCase->description = 'description';
        $useCase->score = $this->faker->randomFloat();
        $useCase->rateSpaceId = $rateSpace->getId()->toString();
        $useCase->userId = $user->getId()->toString();

        return $useCase;
    }
}
