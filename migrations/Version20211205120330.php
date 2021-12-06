<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211205120330 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE unit_owner');
        $this->addSql('ALTER TABLE owner ADD unit_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE owner ADD CONSTRAINT FK_CF60E67CF8BD700D FOREIGN KEY (unit_id) REFERENCES unit (id)');
        $this->addSql('CREATE INDEX IDX_CF60E67CF8BD700D ON owner (unit_id)');
        $this->addSql('ALTER TABLE unit DROP FOREIGN KEY FK_DCBB0C537E3C61F9');
        $this->addSql('DROP INDEX IDX_DCBB0C537E3C61F9 ON unit');
        $this->addSql('ALTER TABLE unit DROP owner_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE unit_owner (unit_id INT NOT NULL, owner_id INT NOT NULL, INDEX IDX_44529877F8BD700D (unit_id), INDEX IDX_445298777E3C61F9 (owner_id), PRIMARY KEY(unit_id, owner_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE unit_owner ADD CONSTRAINT FK_44529877F8BD700D FOREIGN KEY (unit_id) REFERENCES unit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE unit_owner ADD CONSTRAINT FK_445298777E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE owner DROP FOREIGN KEY FK_CF60E67CF8BD700D');
        $this->addSql('DROP INDEX IDX_CF60E67CF8BD700D ON owner');
        $this->addSql('ALTER TABLE owner DROP unit_id');
        $this->addSql('ALTER TABLE unit ADD owner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE unit ADD CONSTRAINT FK_DCBB0C537E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id)');
        $this->addSql('CREATE INDEX IDX_DCBB0C537E3C61F9 ON unit (owner_id)');
    }
}
