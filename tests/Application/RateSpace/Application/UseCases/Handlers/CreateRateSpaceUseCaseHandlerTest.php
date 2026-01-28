<?php

namespace Tests\Application\RateSpace\Application\UseCases\Handlers;

use Application\RateSpace\UseCases\CreateRateSpaceUseCase;
use Domain\RateSpace\Command\CreateRateSpaceCommand;
use Faker\Factory;
use Faker\Generator;
use Tests\Utils\Factory\User\UserFactory;
use Tests\Utils\TestCases\FunctionalTestCase;

final class CreateRateSpaceUseCaseHandlerTest extends FunctionalTestCase
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

        $this->getCommandBus()->assertIsDispatch(CreateRateSpaceUseCase::class);
        $this->getCommandBus()->assertIsDispatch(CreateRateSpaceCommand::class);
    }

    private function buildUseCase(): CreateRateSpaceUseCase
    {
        $user = UserFactory::createOne();

        $useCase = new CreateRateSpaceUseCase();

        $useCase->title = 'title';
        $useCase->description = 'description';
        $useCase->slug = $this->faker->slug();
        $useCase->userId = $user->getId()->toString();

        return $useCase;
    }
}
