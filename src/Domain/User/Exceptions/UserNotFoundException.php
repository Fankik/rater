<?php

namespace Domain\User\Exceptions;

use Symfony\Component\Uid\Uuid;

final class UserNotFoundException extends \DomainException
{
    public static function withId(Uuid $id): self
    {
        return new self(sprintf('Пользователь с ID: "%s" не найден.', $id->toString()));
    }
}
