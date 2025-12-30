<?php

namespace Infrastructure\User\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Domain\User\Entity\ValueObjects\UserRoles;
use Infrastructure\Helpers\Doctrine\Types\JsonbType;

final class UserRolesDoctrineType extends JsonbType
{
    public const string TYPE_NAME = 'user_roles';

    public function getName(): string
    {
        return self::TYPE_NAME;
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): ?UserRoles
    {
        $decodedValue = parent::convertToPHPValue($value, $platform);

        if ($decodedValue === null) {
            return null;
        }

        return UserRoles::fromArray($decodedValue);
    }

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): string
    {
        if (!$value instanceof UserRoles) {
            throw ConversionException::conversionFailed(
                $value::class,
                self::TYPE_NAME,
            );
        }

        return parent::convertToDatabaseValue($value, $platform);
    }
}
