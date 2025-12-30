<?php

namespace Domain\User\Repository;

use Domain\User\Entity\User;
use Symfony\Component\Uid\Uuid;

interface UserRepositoryInterface
{
    public function save(User $user): void;

    public function delete(User $user): void;

    public function findByEmail(string $email): ?User;

    public function findById(Uuid $id): ?User;
}
