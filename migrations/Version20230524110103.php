<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230524110103 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE owner_invoice ADD CONSTRAINT FK_1C13919BC54C8C93 FOREIGN KEY (type_id) REFERENCES owner_invoice_type (id)');
        $this->addSql('CREATE INDEX IDX_1C13919BC54C8C93 ON owner_invoice (type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE owner_invoice DROP FOREIGN KEY FK_1C13919BC54C8C93');
        $this->addSql('DROP INDEX IDX_1C13919BC54C8C93 ON owner_invoice');
    }
}
