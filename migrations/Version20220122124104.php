<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220122124104 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE building DROP FOREIGN KEY FK_E16F61D4D9150B06');
        $this->addSql('DROP INDEX IDX_E16F61D4D9150B06 ON building');
        $this->addSql('ALTER TABLE building CHANGE h_oa_id hoa_id INT NOT NULL');
        $this->addSql('ALTER TABLE building ADD CONSTRAINT FK_E16F61D4549D404C FOREIGN KEY (hoa_id) REFERENCES hoa (id)');
        $this->addSql('CREATE INDEX IDX_E16F61D4549D404C ON building (hoa_id)');
        $this->addSql('ALTER TABLE hoa CHANGE admin_name admin_name VARCHAR(100) NOT NULL, CHANGE admin_phone admin_phone VARCHAR(128) DEFAULT NULL, CHANGE short_name short_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE ledger_account CHANGE hoa_id hoa_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE maintenance_object CHANGE hoa_id hoa_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649CBA4995B');
        $this->addSql('DROP INDEX IDX_8D93D649CBA4995B ON user');
        $this->addSql('ALTER TABLE user DROP active_hoa_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE building DROP FOREIGN KEY FK_E16F61D4549D404C');
        $this->addSql('DROP INDEX IDX_E16F61D4549D404C ON building');
        $this->addSql('ALTER TABLE building CHANGE hoa_id h_oa_id INT NOT NULL');
        $this->addSql('ALTER TABLE building ADD CONSTRAINT FK_E16F61D4D9150B06 FOREIGN KEY (h_oa_id) REFERENCES hoa (id)');
        $this->addSql('CREATE INDEX IDX_E16F61D4D9150B06 ON building (h_oa_id)');
        $this->addSql('ALTER TABLE hoa CHANGE short_name short_name VARCHAR(25) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE admin_name admin_name VARCHAR(120) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE admin_phone admin_phone VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE ledger_account CHANGE hoa_id hoa_id INT NOT NULL');
        $this->addSql('ALTER TABLE maintenance_object CHANGE hoa_id hoa_id INT NOT NULL');
        $this->addSql('ALTER TABLE `user` ADD active_hoa_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649CBA4995B FOREIGN KEY (active_hoa_id) REFERENCES hoa (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649CBA4995B ON `user` (active_hoa_id)');
    }
}
