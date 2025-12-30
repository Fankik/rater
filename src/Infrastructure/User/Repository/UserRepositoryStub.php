<?php

namespace Infrastructure\User\Repository;

use Domain\User\Entity\User;
use Domain\User\Repository\UserRepositoryInterface;
use Infrastructure\Helpers\Repository\AbstractRepositoryStub;
use Symfony\Component\Uid\Uuid;

final class UserRepositoryStub extends AbstractRepositoryStub implements UserRepositoryInterface
{
    public function save(User $user): void
    {
        $this->setExpected($user);
    }

    /** @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter */
    public function delete(User $user): void
    {
        $this->setExpected(null);
    }

    /** @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter */
    public function findById(Uuid $id): ?User
    {
        return $this->getExpected();
    }

    /** @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter */
    public function findByEmail(string $email): ?User
    {
        return $this->getExpected();
    }
}
