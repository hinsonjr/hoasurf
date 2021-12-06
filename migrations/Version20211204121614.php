<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211204121614 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE unit DROP FOREIGN KEY FK_DCBB0C53E3441BD3');
        $this->addSql('DROP INDEX IDX_DCBB0C53E3441BD3 ON unit');
        $this->addSql('ALTER TABLE unit ADD last_sale_data DATE DEFAULT NULL, DROP current_owner_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE unit ADD current_owner_id INT DEFAULT NULL, DROP last_sale_data');
        $this->addSql('ALTER TABLE unit ADD CONSTRAINT FK_DCBB0C53E3441BD3 FOREIGN KEY (current_owner_id) REFERENCES owner (id)');
        $this->addSql('CREATE INDEX IDX_DCBB0C53E3441BD3 ON unit (current_owner_id)');
    }
}
