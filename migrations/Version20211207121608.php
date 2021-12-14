<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211207121608 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE building ADD CONSTRAINT FK_E16F61D4D9150B06 FOREIGN KEY (h_oa_id) REFERENCES hoa (id)');
        $this->addSql('CREATE INDEX IDX_E16F61D4D9150B06 ON building (h_oa_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE building DROP FOREIGN KEY FK_E16F61D4D9150B06');
        $this->addSql('DROP INDEX IDX_E16F61D4D9150B06 ON building');
    }
}
