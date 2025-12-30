<?php

namespace Application\Security;

use Domain\User\Entity\User;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final readonly class SecurityUser implements UserInterface, PasswordAuthenticatedUserInterface
{
    public function __construct(
        private User $user,
    ) {
    }

    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return array<string>
     */
    public function getRoles(): array
    {
        $rolesByTypes = array_map(
            static fn (string $type): string => sprintf('ROLE_%s', mb_strtoupper($type)),
            $this->user->getRoles()->values(),
        );

        return array_unique(['ROLE_USER', ...$rolesByTypes]);
    }

    public function hasRole(string $role): bool
    {
        return \in_array($role, $this->getRoles(), true);
    }

    public function getUserIdentifier(): string
    {
        $email = $this->user->getEmail();

        if ($email === '') {
            throw new \RuntimeException('У пользователя отсутствует Email.');
        }

        return $email;
    }

    /**
     * {@inheritDoc}
     */
    public function eraseCredentials(): void
    {
        // nothing to do
    }

    public function getPassword(): string
    {
        return $this->user->getHashedPassword();
    }
}
