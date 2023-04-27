<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230426105606 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message DROP INDEX UNIQ_B6BD307F158E0B66, ADD INDEX IDX_B6BD307F158E0B66 (target_id)');
        $this->addSql('ALTER TABLE message ADD expiration DATE DEFAULT NULL, CHANGE target_id target_id INT DEFAULT NULL, CHANGE body body LONGTEXT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message DROP INDEX IDX_B6BD307F158E0B66, ADD UNIQUE INDEX UNIQ_B6BD307F158E0B66 (target_id)');
        $this->addSql('ALTER TABLE message DROP expiration, CHANGE target_id target_id INT NOT NULL, CHANGE body body MEDIUMTEXT NOT NULL');
    }
}
