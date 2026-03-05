<?php

namespace Domain\RateSpace\Exceptions;

use Symfony\Component\Uid\Uuid;

final class RateSpaceNotFoundException extends \DomainException
{
    public static function withId(Uuid $id): self
    {
        return new self(sprintf('Пространство с ID: "%s" не найдено', $id->toString()));
    }
}
