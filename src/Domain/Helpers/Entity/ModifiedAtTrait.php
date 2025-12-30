<?php

namespace Domain\Helpers\Entity;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait ModifiedAtTrait
{
    #[ORM\Column(
        name: 'modified_at',
        type: Types::DATETIME_IMMUTABLE,
        nullable: true,
    )]
    protected ?DateTimeImmutable $modifiedAt = null;

    public function getModifiedAt(): ?DateTimeImmutable
    {
        return $this->modifiedAt;
    }

    public function setModifiedAt(DateTimeImmutable $modifiedAt): static
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->modifiedAt = new DateTimeImmutable();
    }
}
