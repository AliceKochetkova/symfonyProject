<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250320093030 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE blog ADD percent SMALLINT DEFAULT NULL');
       }

    public function down(Schema $schema): void
    {
       $this->addSql('ALTER TABLE blog DROP percent');
    }
}
