<?php

namespace Tests\Infrastructure\User\Repository;

use Domain\User\Entity\User;
use Domain\User\Entity\ValueObjects\UserRole;
use Domain\User\Entity\ValueObjects\UserRoles;
use Domain\User\Repository\UserRepositoryInterface;
use Infrastructure\User\Repository\UserRepository;
use Tests\Utils\Factory\User\UserFactory;
use Tests\Utils\TestCases\FunctionalTestCase;

final class UserRepositoryTest extends FunctionalTestCase
{
    private UserRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->getServiceByClassName(UserRepository::class);
    }

    public function testUserMustBeCreated(): void
    {
        $expectedUser = UserFactory::createOne();

        $this->repository->save($expectedUser);

        $findUser = $this->repository->findById($expectedUser->getId());

        assert($findUser instanceof User);

        self::assertTrue($expectedUser->getId()->equals($findUser->getId()));
    }

    public function testUserMustBeUpdated(): void
    {
        $user = UserFactory::createOne([
            'name' => 'Test',
            'email' => 'Test email',
            'roles' => UserRoles::fromArray([]),
        ]);

        $expectedUser = [
            'name' => 'My name',
            'email' => 'My email',
            'roles' => UserRoles::fromArray([UserRole::Admin->value]),
        ];

        self::assertNotSame($user->getName(), $expectedUser['name']);
        self::assertNotSame($user->getEmail(), $expectedUser['email']);
        self::assertNotSame($user->getRoles()->values(), $expectedUser['roles']->values());

        $user->update(
            name: $user->getName(),
            email: $user->getEmail(),
            roles: $user->getRoles(),
        );

        $this->repository->save($user);

        $findUser = $this->repository->findById($user->getId());

        assert($findUser instanceof User);

        self::assertSame($findUser->getName(), $findUser->getName());
        self::assertSame($findUser->getEmail(), $findUser->getEmail());
        self::assertSame($findUser->getRoles(), $findUser->getRoles());
    }

    public function testUserMustBeDeleted(): void
    {
        $user = UserFactory::createOne();

        $findUser = $this->repository->findById($user->getId());

        assert($findUser instanceof User);

        self::assertTrue($findUser->getId()->equals($findUser->getId()));

        $this->repository->delete($findUser);

        $findUser = $this->repository->findById($user->getId());

        self::assertNull($findUser);
    }

    public function testUserMustBeFindById(): void
    {
        $user = UserFactory::createOne();

        $findUser = $this->repository->findById($user->getId());

        assert($findUser instanceof User);

        self::assertTrue($findUser->getId()->equals($findUser->getId()));
    }

    public function testUserMustBeFindByEmail(): void
    {
        $user = UserFactory::createOne();

        $findUser = $this->repository->findByEmail($user->getEmail());

        assert($findUser instanceof User);

        self::assertTrue($findUser->getId()->equals($findUser->getId()));
    }
}
