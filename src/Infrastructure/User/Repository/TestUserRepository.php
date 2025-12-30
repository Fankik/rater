<?php

namespace Infrastructure\User\Repository;

use Domain\User\Entity\User;
use Domain\User\Repository\UserRepositoryInterface;
use Symfony\Component\Uid\Uuid;

final class TestUserRepository implements UserRepositoryInterface
{
    private bool $useRealRepository = true;

    public function __construct(
        private readonly UserRepositoryInterface $realRepository,
        private readonly UserRepositoryInterface $stubRepository,
    ) {
    }

    public function useReal(): void
    {
        $this->useRealRepository = true;
    }

    public function useStub(): void
    {
        $this->useRealRepository = false;
    }

    private function getProxiedRepository(): UserRepositoryInterface
    {
        return $this->useRealRepository ? $this->realRepository : $this->stubRepository;
    }

    public function save(User $user): void
    {
        $this->getProxiedRepository()->save($user);
    }

    public function delete(User $user): void
    {
        $this->getProxiedRepository()->delete($user);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->getProxiedRepository()->findByEmail($email);
    }

    public function findById(Uuid $id): ?User
    {
        return $this->getProxiedRepository()->findById($id);
    }
}
