<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230525132507 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE owner_invoice ADD CONSTRAINT FK_1C13919BB028B6B FOREIGN KEY (unit_owner_id) REFERENCES unit_owner (id)');
        $this->addSql('CREATE INDEX IDX_1C13919BB028B6B ON owner_invoice (unit_owner_id)');
        $this->addSql('ALTER TABLE unit_owner DROP FOREIGN KEY FK_1929416E7E3C61F9');
        $this->addSql('ALTER TABLE unit_owner DROP FOREIGN KEY FK_1929416EF8BD700D');
        $this->addSql('DROP INDEX idx_d52b790c7e3c61f9 ON unit_owner');
        $this->addSql('CREATE INDEX IDX_445298777E3C61F9 ON unit_owner (owner_id)');
        $this->addSql('DROP INDEX idx_d52b790cf8bd700d ON unit_owner');
        $this->addSql('CREATE INDEX IDX_44529877F8BD700D ON unit_owner (unit_id)');
        $this->addSql('ALTER TABLE unit_owner ADD CONSTRAINT FK_1929416E7E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id)');
        $this->addSql('ALTER TABLE unit_owner ADD CONSTRAINT FK_1929416EF8BD700D FOREIGN KEY (unit_id) REFERENCES unit (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE owner_invoice DROP FOREIGN KEY FK_1C13919BB028B6B');
        $this->addSql('DROP INDEX IDX_1C13919BB028B6B ON owner_invoice');
        $this->addSql('ALTER TABLE unit_owner DROP FOREIGN KEY FK_445298777E3C61F9');
        $this->addSql('ALTER TABLE unit_owner DROP FOREIGN KEY FK_44529877F8BD700D');
        $this->addSql('DROP INDEX idx_445298777e3c61f9 ON unit_owner');
        $this->addSql('CREATE INDEX IDX_D52B790C7E3C61F9 ON unit_owner (owner_id)');
        $this->addSql('DROP INDEX idx_44529877f8bd700d ON unit_owner');
        $this->addSql('CREATE INDEX IDX_D52B790CF8BD700D ON unit_owner (unit_id)');
        $this->addSql('ALTER TABLE unit_owner ADD CONSTRAINT FK_445298777E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id)');
        $this->addSql('ALTER TABLE unit_owner ADD CONSTRAINT FK_44529877F8BD700D FOREIGN KEY (unit_id) REFERENCES unit (id)');
    }
}
