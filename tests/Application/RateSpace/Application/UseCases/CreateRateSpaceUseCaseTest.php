<?php

namespace Tests\Application\RateSpace\Application\UseCases;

use Application\RateSpace\UseCases\CreateRateSpaceUseCase;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\Uid\Uuid;
use Tests\Utils\Assertion\Common\ViolationsHasMessageAssertion;
use Tests\Utils\Factory\RateSpace\RateSpaceWithRandomUserFactory;
use Tests\Utils\Factory\User\UserFactory;
use Tests\Utils\TestCases\FunctionalTestCase;

final class CreateRateSpaceUseCaseTest extends FunctionalTestCase
{
    private Generator $faker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();
    }

    public function testUseCaseMustBeValid(): void
    {
        $useCase = $this->buildUseCase();

        $errors = $this->getValidator()->validate($useCase);

        self::assertEmpty($errors);
    }

    public function testUseCaseMustBeValidIfTitleIsBlank(): void
    {
        $useCase = $this->buildUseCase([
            'title' => '',
        ]);

        $errors = $this->getValidator()->validate($useCase);

        self::assertCount(1, $errors);
        self::assertThat(
            $errors,
            new ViolationsHasMessageAssertion('title', 'Название должно быть заполнено.'),
        );
    }

    public function testUseCaseMustBeValidIfRateSpaceWithSameSlugExist(): void
    {
        $slug = 'slug';

        $useCase = $this->buildUseCase([
            'slug' => $slug,
        ]);

        RateSpaceWithRandomUserFactory::createOne(['slug' => $slug]);

        $errors = $this->getValidator()->validate($useCase);

        self::assertCount(1, $errors);
        self::assertThat(
            $errors,
            new ViolationsHasMessageAssertion('slug', 'Такое пространство для оценки уже существует.'),
        );
    }

    public function testUseCaseMustBeValidIfRateSpaceWithNotExistUser(): void
    {
        $useCase = $this->buildUseCase([
            'userId' => Uuid::v7()->toString(),
        ]);

        $errors = $this->getValidator()->validate($useCase);

        self::assertCount(1, $errors);
        self::assertThat(
            $errors,
            new ViolationsHasMessageAssertion('userId', 'Пользователь не найден.'),
        );
    }

    /** @param array<mixed> $data */
    private function buildUseCase(array $data = []): CreateRateSpaceUseCase
    {
        $user = UserFactory::createOne();

        $useCase = new CreateRateSpaceUseCase();

        $useCase->title = $data['title'] ?? 'test title';
        $useCase->description = $data['description'] ?? 'description';
        $useCase->slug = $data['slug'] ?? $this->faker->slug();
        $useCase->userId = $data['userId'] ?? $user->getId()->toString();

        return $useCase;
    }
}
