<?php

namespace Tests\Domain\User\Query\Handlers;

use Domain\User\Entity\User;
use Domain\User\Exceptions\UserNotFoundException;
use Domain\User\Query\GetUserByIdQuery;
use Symfony\Component\Uid\Uuid;
use Tests\Utils\Factory\User\UserFactory;
use Tests\Utils\TestCases\FunctionalTestCase;

final class GetUserByIdQueryHandlerTest extends FunctionalTestCase
{
    public function testUserMustBeGet(): void
    {
        $user = UserFactory::createOne();

        $query = new GetUserByIdQuery(
            id: $user->getId(),
        );

        $findUser = $this->getQueryBus()->dispatch($query);

        assert($findUser instanceof User);

        self::assertTrue($user->getId()->equals($findUser->getId()));
    }

    public function testThrowExceptionWhenUserIsNotFound(): void
    {
        $this->expectException(UserNotFoundException::class);

        $userId = Uuid::v7();

        $query = new GetUserByIdQuery(
            id: $userId,
        );

        $this->getQueryBus()->dispatch($query);
    }
}
