<?php

namespace Application\Helpers\EventListeners;

use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Schema\PostgreSQLSchemaManager;
use Doctrine\DBAL\Schema\SchemaException;
use Doctrine\ORM\Tools\Event\GenerateSchemaEventArgs;

/**
 * @see https://github.com/doctrine/dbal/issues/1110#issuecomment-255765189
 */
final class MigrationEventListener
{
    /**
     * @throws Exception
     * @throws SchemaException
     */
    public function postGenerateSchema(GenerateSchemaEventArgs $generateSchemaEventArgs): void
    {
        $schemaManager = $generateSchemaEventArgs->getEntityManager()
            ->getConnection()
            ->createSchemaManager();

        if (!$schemaManager instanceof PostgreSqlSchemaManager) {
            return;
        }

        foreach ($schemaManager->getExistingSchemaSearchPaths() as $existingSchemaSearchPath) {
            if ($generateSchemaEventArgs->getSchema()->hasNamespace($existingSchemaSearchPath)) {
                continue;
            }

            $generateSchemaEventArgs->getSchema()->createNamespace($existingSchemaSearchPath);
        }
    }
}
