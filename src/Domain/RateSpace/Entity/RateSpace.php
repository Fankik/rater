<?php

namespace Domain\RateSpace\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Domain\Helpers\Entity\CreatedAtTrait;
use Domain\Helpers\Entity\ModifiedAtTrait;
use Domain\User\Entity\User;
use Symfony\Component\Uid\Uuid;

/** @final */
#[ORM\Table(name: 'rate_spaces')]
#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
class RateSpace
{
    use CreatedAtTrait;
    use ModifiedAtTrait;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private Uuid $id;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $title;

    #[ORM\Column(type: Types::TEXT, length: 255)]
    private string $description;

    #[ORM\Column(type: Types::STRING, length: 255, unique: true)]
    private string $slug;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'rateSpaces')]
    private User $user;

    public function __construct(
        string $title,
        string $description,
        string $slug,
        User $user,
        ?Uuid $id = null,
    ) {
        $this->id = $id ?? Uuid::v7();
        $this->title = $title;
        $this->description = $description;
        $this->slug = $slug;
        $this->user = $user;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
