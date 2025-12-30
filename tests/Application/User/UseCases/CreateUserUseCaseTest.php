<?php

namespace Tests\Application\User\UseCases;

use Application\User\UseCases\CreateUserUseCase;
use Domain\User\Entity\ValueObjects\UserRole;
use Tests\Utils\Assertion\Common\ViolationsHasMessageAssertion;
use Tests\Utils\Factory\User\UserFactory;
use Tests\Utils\TestCases\FunctionalTestCase;

final class CreateUserUseCaseTest extends FunctionalTestCase
{
    public function testUseCaseMustBeValid(): void
    {
        $useCase = self::buildUseCase();

        $errors = $this->getValidator()->validate($useCase);

        self::assertEmpty($errors);
    }

    public function testUseCaseMustNotBeValidWithExistEmail(): void
    {
        $email = 'test.email@test.com';

        UserFactory::createOne([
            'email' => $email,
        ]);

        $useCase = self::buildUseCase([
            'email' => $email,
        ]);

        $errors = $this->getValidator()->validate($useCase);

        self::assertThat(
            $errors,
            new ViolationsHasMessageAssertion('email', 'Пользователь с email существует.'),
        );
    }

    public function testUseCaseMustNotBeValidWithIncorrectEmail(): void
    {
        $useCase = self::buildUseCase([
            'email' => 'test',
        ]);

        $errors = $this->getValidator()->validate($useCase);

        self::assertThat(
            $errors,
            new ViolationsHasMessageAssertion('email', 'Некорректный Email.'),
        );
    }

    public function testUseCaseMustNotBeValidWithShortPassword(): void
    {
        $useCase = self::buildUseCase([
            'password' => 'test',
        ]);

        $errors = $this->getValidator()->validate($useCase);

        self::assertThat(
            $errors,
            new ViolationsHasMessageAssertion('password', 'Минимально допустимый пароль 6 символов.'),
        );
    }

    public function testUseCaseMustNotBeValidWithLongPassword(): void
    {
        $useCase = self::buildUseCase([
            'password' => str_repeat('a', 256),
        ]);

        $errors = $this->getValidator()->validate($useCase);

        self::assertThat(
            $errors,
            new ViolationsHasMessageAssertion('password', 'Максимально допустимый пароль 255 символов.'),
        );
    }

    public function testUseCaseMustNotBeValidWithIncorrectUserRole(): void
    {
        $useCase = self::buildUseCase([
            'roles' => [
                'invalid_role',
            ],
        ]);

        $errors = $this->getValidator()->validate($useCase);

        self::assertThat(
            $errors,
            new ViolationsHasMessageAssertion('roles[0]', 'Такой роли не существует.'),
        );
    }

    /** @param array<mixed> $data */
    private static function buildUseCase(array $data = []): CreateUserUseCase
    {
        $useCase = new CreateUserUseCase();

        $useCase->name = $data['name'] ?? 'test name';
        $useCase->email = $data['email'] ?? 'test@test.com';
        $useCase->password = $data['password'] ?? 'test password';
        $useCase->roles = $data['roles'] ?? [
            UserRole::Admin->value,
        ];

        return $useCase;
    }
}
