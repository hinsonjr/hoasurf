<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211201125322 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE building (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, address1 VARCHAR(128) NOT NULL, address2 VARCHAR(128) DEFAULT NULL, city VARCHAR(128) DEFAULT NULL, state VARCHAR(128) DEFAULT NULL, zip VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE unit_owner (unit_id INT NOT NULL, owner_id INT NOT NULL, INDEX IDX_44529877F8BD700D (unit_id), INDEX IDX_445298777E3C61F9 (owner_id), PRIMARY KEY(unit_id, owner_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE unit_owner ADD CONSTRAINT FK_44529877F8BD700D FOREIGN KEY (unit_id) REFERENCES unit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE unit_owner ADD CONSTRAINT FK_445298777E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE unit ADD building_id INT DEFAULT NULL, ADD unit_number VARCHAR(30) NOT NULL, ADD description LONGBLOB DEFAULT NULL, ADD sf VARCHAR(10) DEFAULT NULL, ADD beds VARCHAR(5) DEFAULT NULL, ADD baths VARCHAR(5) DEFAULT NULL, ADD last_sale_data DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE unit ADD CONSTRAINT FK_DCBB0C534D2A7E12 FOREIGN KEY (building_id) REFERENCES building (id)');
        $this->addSql('CREATE INDEX IDX_DCBB0C534D2A7E12 ON unit (building_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE unit DROP FOREIGN KEY FK_DCBB0C534D2A7E12');
        $this->addSql('DROP TABLE building');
        $this->addSql('DROP TABLE unit_owner');
        $this->addSql('DROP INDEX IDX_DCBB0C534D2A7E12 ON unit');
        $this->addSql('ALTER TABLE unit DROP building_id, DROP unit_number, DROP description, DROP sf, DROP beds, DROP baths, DROP last_sale_data');
    }
}
