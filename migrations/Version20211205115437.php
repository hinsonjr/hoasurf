<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211205115437 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE unit ADD owner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE unit ADD CONSTRAINT FK_DCBB0C537E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id)');
        $this->addSql('CREATE INDEX IDX_DCBB0C537E3C61F9 ON unit (owner_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE unit DROP FOREIGN KEY FK_DCBB0C537E3C61F9');
        $this->addSql('DROP INDEX IDX_DCBB0C537E3C61F9 ON unit');
        $this->addSql('ALTER TABLE unit DROP owner_id');
    }
}
