<?php

namespace Domain\RateItem\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Domain\Helpers\Entity\CreatedAtTrait;
use Domain\Helpers\Entity\ModifiedAtTrait;
use Domain\RateSpace\Entity\RateSpace;
use Domain\User\Entity\User;
use Symfony\Component\Uid\Uuid;

/** @final */
#[ORM\Table(name: 'rate_items')]
#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
class RateItem
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

    #[ORM\Column(type: Types::FLOAT)]
    private float $score;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'rateItems')]
    private User $user;

    #[ORM\ManyToOne(targetEntity: RateSpace::class, inversedBy: 'rateItems')]
    private RateSpace $rateSpace;

    public function __construct(
        string $title,
        string $description,
        float $score,
        RateSpace $rateSpace,
        User $user,
        ?Uuid $id = null,
    ) {
        $this->id = $id ?? Uuid::v7();
        $this->title = $title;
        $this->description = $description;
        $this->score = $score;
        $this->rateSpace = $rateSpace;
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

    public function getScore(): float
    {
        return $this->score;
    }

    public function getRateSpace(): RateSpace
    {
        return $this->rateSpace;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
