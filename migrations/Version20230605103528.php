<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230605103528 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE request_note (id INT AUTO_INCREMENT NOT NULL, added_by_id INT NOT NULL, request_id INT NOT NULL, note LONGTEXT NOT NULL, date DATETIME NOT NULL, INDEX IDX_B01ADDEE55B127A4 (added_by_id), INDEX IDX_B01ADDEE427EB8A5 (request_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE request_note ADD CONSTRAINT FK_B01ADDEE55B127A4 FOREIGN KEY (added_by_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE request_note ADD CONSTRAINT FK_B01ADDEE427EB8A5 FOREIGN KEY (request_id) REFERENCES request (id)');
        $this->addSql('ALTER TABLE request DROP notes');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE request_note DROP FOREIGN KEY FK_B01ADDEE55B127A4');
        $this->addSql('ALTER TABLE request_note DROP FOREIGN KEY FK_B01ADDEE427EB8A5');
        $this->addSql('DROP TABLE request_note');
        $this->addSql('ALTER TABLE request ADD notes LONGTEXT DEFAULT NULL');
    }
}
