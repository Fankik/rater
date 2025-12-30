<?php

namespace Infrastructure\Helpers\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Platforms\PostgreSQLPlatform;
use Doctrine\DBAL\Types\JsonType;

abstract class JsonbType extends JsonType
{
    /** @param array<mixed> $column */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        if ($platform instanceof PostgreSQLPlatform) {
            return 'JSONB';
        }

        return parent::getSQLDeclaration($column, $platform);
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    /**
     * @return array<string>
     */
    public function getMappedDatabaseTypes(AbstractPlatform $platform): array
    {
        if ($platform instanceof PostgreSQLPlatform) {
            return ['jsonb'];
        }

        return parent::getMappedDatabaseTypes($platform);
    }
}
