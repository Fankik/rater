<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260201212649 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Добавлен visible_type для rate_spaces';
    }

    /**
    * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
    */
    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE rate_spaces ADD visible_type VARCHAR(32) NOT NULL');
    }

    /**
    * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
    */
    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE rate_spaces DROP visible_type');
    }
}
