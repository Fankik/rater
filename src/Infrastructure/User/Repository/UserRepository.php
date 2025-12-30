<?php

namespace Infrastructure\User\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Domain\User\Entity\User;
use Domain\User\Repository\UserRepositoryInterface;
use Symfony\Component\Uid\Uuid;

final readonly class UserRepository implements UserRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function save(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function delete(User $user): void
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }

    public function findById(Uuid $id): ?User
    {
        return $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(['id' => $id->toString()]);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(['email' => $email]);
    }
}
