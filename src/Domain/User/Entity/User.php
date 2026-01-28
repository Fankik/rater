<?php

namespace Domain\User\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Domain\Helpers\Entity\CreatedAtTrait;
use Domain\Helpers\Entity\ModifiedAtTrait;
use Domain\RateSpace\Entity\RateSpace;
use Domain\User\Entity\ValueObjects\UserRoles;
use Symfony\Component\Uid\Uuid;

/** @final */
#[ORM\Table(name: 'users')]
#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
class User
{
    use CreatedAtTrait;
    use ModifiedAtTrait;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private Uuid $id;

    #[ORM\Column(type: 'string')]
    private string $name;

    #[ORM\Column(type: 'string', length: 254, unique: true)]
    private string $email;

    #[ORM\Column(type: 'user_roles')]
    private UserRoles $roles;

    #[ORM\Column(name: 'password', type: 'string', length: 64)]
    private string $hashedPassword;

    /** @var Collection<int, RateSpace> */
    #[ORM\OneToMany(targetEntity: RateSpace::class, mappedBy: 'user', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $rateSpaces;

    public function __construct(
        string $name,
        string $email,
        UserRoles $roles,
        string $hashedPassword,
        ?Uuid $id = null,
    ) {
        $this->id = $id ?? Uuid::v7();
        $this->name = $name;
        $this->email = $email;
        $this->roles = $roles;
        $this->hashedPassword = $hashedPassword;
        $this->rateSpaces = new ArrayCollection();
    }

    public function update(
        string $name,
        string $email,
        UserRoles $roles,
    ): void {
        $this->name = $name;
        $this->email = $email;
        $this->roles = $roles;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRoles(): UserRoles
    {
        return $this->roles;
    }

    public function getHashedPassword(): string
    {
        return $this->hashedPassword;
    }

    /** @return Collection<int, RateSpace> */
    public function getRateSpaces(): Collection
    {
        return $this->rateSpaces;
    }
}
