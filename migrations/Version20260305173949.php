<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260305173949 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Добавлена таблица rate_items';
    }

    /**
    * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
    */
    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
            CREATE TABLE rate_items (
                id UUID NOT NULL,
                user_id UUID DEFAULT NULL,
                rate_space_id UUID DEFAULT NULL,
                title VARCHAR(255) NOT NULL,
                description TEXT NOT NULL,
                score DOUBLE PRECISION NOT NULL,
                created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
                modified_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
                PRIMARY KEY(id)
            )
        SQL);
        $this->addSql('CREATE INDEX IDX_715EF06EA76ED395 ON rate_items (user_id)');
        $this->addSql('CREATE INDEX IDX_715EF06EF48043E1 ON rate_items (rate_space_id)');
        $this->addSql('COMMENT ON COLUMN rate_items.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN rate_items.user_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN rate_items.rate_space_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN rate_items.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN rate_items.modified_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE rate_items ADD CONSTRAINT FK_715EF06EA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rate_items ADD CONSTRAINT FK_715EF06EF48043E1 FOREIGN KEY (rate_space_id) REFERENCES rate_spaces (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
    * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
    */
    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE rate_items DROP CONSTRAINT FK_715EF06EA76ED395');
        $this->addSql('ALTER TABLE rate_items DROP CONSTRAINT FK_715EF06EF48043E1');
        $this->addSql('DROP TABLE rate_items');
    }
}
