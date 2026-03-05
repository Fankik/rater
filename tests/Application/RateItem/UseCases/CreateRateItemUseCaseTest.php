<?php

namespace Tests\Application\RateItem\UseCases;

use Application\RateItem\UseCase\CreateRateItemUseCase;
use Domain\RateSpace\Entity\ValueObjects\RateSpaceVisibleType;
use Domain\RateSpace\Validator\RateSpaceVisible\RateSpaceVisibleAccess;
use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\Uid\Uuid;
use Tests\Utils\Assertion\Common\ViolationsHasMessageAssertion;
use Tests\Utils\Factory\RateSpace\RateSpaceWithRandomUserFactory;
use Tests\Utils\Factory\User\UserFactory;
use Tests\Utils\TestCases\FunctionalTestCase;

final class CreateRateItemUseCaseTest extends FunctionalTestCase
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

    public function testUseCaseMustBeValidIfRateItemIfScoreNotValid(): void
    {
        $useCase = $this->buildUseCase([
            'score' => '',
        ]);

        $errors = $this->getValidator()->validate($useCase);

        self::assertCount(3, $errors);

        self::assertThat(
            $errors,
            new ViolationsHasMessageAssertion('score', 'Оценка должна быть заполнена.'),
        );

        self::assertThat(
            $errors,
            new ViolationsHasMessageAssertion('score', 'Оценка не может быть отрицательной.'),
        );

        self::assertThat(
            $errors,
            new ViolationsHasMessageAssertion('score', 'Оценка должна быть числом.'),
        );
    }

    public function testUseCaseMustBeValidIfRateItemWithNotExistRateSpace(): void
    {
        $useCase = $this->buildUseCase([
            'rateSpaceId' => Uuid::v7()->toString(),
        ]);

        $errors = $this->getValidator()->validate($useCase);

        self::assertCount(1, $errors);
        self::assertThat(
            $errors,
            new ViolationsHasMessageAssertion('rateSpaceId', 'Пространства не существует.'),
        );
    }

    #[DataProvider('rateSpaceVisibilityProvider')]
    public function testUseCaseMustBeValidIfRateItemWithNotAccessRateSpace(RateSpaceVisibleType $visibleType): void
    {
        $rateSpace = RateSpaceWithRandomUserFactory::createOne([
            'visibleType' => $visibleType,
        ]);

        $useCase = $this->buildUseCase([
            'rateSpaceId' => $rateSpace->getId()->toString(),
        ]);

        $errors = $this->getValidator()->validate($useCase);

        self::assertCount(1, $errors);
        self::assertThat(
            $errors,
            new ViolationsHasMessageAssertion('rateSpaceId', RateSpaceVisibleAccess::NOT_ACCESS_MESSAGE),
        );
    }

    public function testUseCaseMustBeValidIfRateItemWithNotExistUser(): void
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

    /** @return array<array<RateSpaceVisibleType>> */
    public static function rateSpaceVisibilityProvider(): array
    {
        return [
            [RateSpaceVisibleType::Private],
            [RateSpaceVisibleType::PublicReadOnly],
        ];
    }

    /** @param array<mixed> $data */
    private function buildUseCase(array $data = []): CreateRateItemUseCase
    {
        $user = UserFactory::createOne();
        $rateSpace = RateSpaceWithRandomUserFactory::createOne();

        $useCase = new CreateRateItemUseCase();

        $useCase->title = $data['title'] ?? 'test title';
        $useCase->description = $data['description'] ?? 'description';
        $useCase->score = $data['score'] ?? $this->faker->randomFloat();
        $useCase->rateSpaceId = $data['rateSpaceId'] ?? $rateSpace->getId()->toString();
        $useCase->userId = $data['userId'] ?? $user->getId()->toString();

        return $useCase;
    }
}
