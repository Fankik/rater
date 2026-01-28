<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260128185444 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Создание таблицы rate_spaces';
    }

    /**
    * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
    */
    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
            CREATE TABLE rate_spaces (
                id UUID NOT NULL,
                user_id UUID DEFAULT NULL,
                title VARCHAR(255) NOT NULL,
                description TEXT NOT NULL,
                slug VARCHAR(255) NOT NULL,
                created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
                modified_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
                PRIMARY KEY(id)
            )
        SQL);
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7FDC5513989D9B62 ON rate_spaces (slug)');
        $this->addSql('CREATE INDEX IDX_7FDC5513A76ED395 ON rate_spaces (user_id)');
        $this->addSql('COMMENT ON COLUMN rate_spaces.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN rate_spaces.user_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN rate_spaces.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN rate_spaces.modified_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE rate_spaces ADD CONSTRAINT FK_7FDC5513A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
    * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
    */
    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE rate_spaces DROP CONSTRAINT FK_7FDC5513A76ED395');
        $this->addSql('DROP TABLE rate_spaces');
    }
}
