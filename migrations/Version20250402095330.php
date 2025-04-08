<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250402095330 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE blog ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE blog ALTER status SET DEFAULT NULL');
        $this->addSql('ALTER TABLE blog ALTER blocked_at SET DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_147AB9DBAD26311 ON tags_to_blog (tag_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE INDEX IDX_147AB9DBAD26311 ON tags_to_blog (tag_id)');
        $this->addSql('ALTER TABLE blog DROP created_at');
        $this->addSql('ALTER TABLE blog DROP updated_at');
        $this->addSql('ALTER TABLE blog ALTER status DROP NOT NULL');
        $this->addSql('ALTER TABLE blog ALTER blocked_at DROP NOT NULL');
    }
}
