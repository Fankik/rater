<?php

namespace Domain\User\Entity\ValueObjects;

/**
 * @final
 */
class UserRoles
{
    /** @var array<UserRole> */
    private array $roles;

    public function __construct(UserRole ...$roles)
    {
        $this->roles = $roles;
    }

    public function has(UserRole $type): bool
    {
        return in_array($type, $this->roles, true);
    }

    /**
     * @return array<int, string>
     */
    public function values(): array
    {
        return array_column($this->roles, 'value');
    }

    /**
     * @param array<string> $array
     */
    public static function fromArray(array $array): self
    {
        return new self(...array_map(static fn (string $role): UserRole => UserRole::from($role), $array));
    }

    public function hasAdmin(): bool
    {
        return $this->has(UserRole::Admin);
    }
}
