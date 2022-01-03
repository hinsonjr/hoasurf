<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220102163859 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE building (id INT AUTO_INCREMENT NOT NULL, h_oa_id INT NOT NULL, name VARCHAR(100) NOT NULL, address1 VARCHAR(128) NOT NULL, address2 VARCHAR(128) DEFAULT NULL, city VARCHAR(128) DEFAULT NULL, state VARCHAR(128) DEFAULT NULL, zip VARCHAR(10) NOT NULL, INDEX IDX_E16F61D4D9150B06 (h_oa_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hoa (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, admin_name VARCHAR(120) DEFAULT NULL, admin_phone VARCHAR(20) DEFAULT NULL, admin_email VARCHAR(255) DEFAULT NULL, short_name VARCHAR(25) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ledger_account (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, owner_id INT DEFAULT NULL, vendor_id INT DEFAULT NULL, hoa_id INT NOT NULL, name VARCHAR(255) NOT NULL, balance NUMERIC(12, 2) DEFAULT \'0\' NOT NULL, start_balance NUMERIC(12, 2) DEFAULT \'0\' NOT NULL, INDEX IDX_B3339695C54C8C93 (type_id), INDEX IDX_B33396957E3C61F9 (owner_id), INDEX IDX_B3339695F603EE73 (vendor_id), INDEX IDX_B3339695549D404C (hoa_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ledger_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(24) NOT NULL, is_debit TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE maintenance_object (id INT AUTO_INCREMENT NOT NULL, vendor_id INT DEFAULT NULL, hoa_id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, period VARCHAR(255) DEFAULT NULL, period_amount NUMERIC(16, 2) DEFAULT NULL, location VARCHAR(255) DEFAULT NULL, INDEX IDX_82509DE5F603EE73 (vendor_id), INDEX IDX_82509DE5549D404C (hoa_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE owner (id INT AUTO_INCREMENT NOT NULL, unit_id INT DEFAULT NULL, user_id INT DEFAULT NULL, name VARCHAR(200) NOT NULL, start_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, address VARCHAR(100) DEFAULT NULL, address2 VARCHAR(80) DEFAULT NULL, city VARCHAR(100) DEFAULT NULL, state VARCHAR(50) DEFAULT NULL, zip VARCHAR(10) DEFAULT NULL, phone VARCHAR(20) DEFAULT NULL, country VARCHAR(100) DEFAULT \'US\', own_percent DOUBLE PRECISION DEFAULT \'100\' NOT NULL, INDEX IDX_CF60E67CF8BD700D (unit_id), INDEX IDX_CF60E67CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, role_name VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, credit_account_id INT NOT NULL, debit_account_id INT NOT NULL, date DATETIME NOT NULL, amount NUMERIC(12, 2) NOT NULL, deleted TINYINT(1) DEFAULT \'0\' NOT NULL, INDEX IDX_723705D16813E404 (credit_account_id), INDEX IDX_723705D1204C4EAA (debit_account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE unit (id INT AUTO_INCREMENT NOT NULL, building_id INT DEFAULT NULL, unit_number VARCHAR(30) NOT NULL, description LONGTEXT DEFAULT NULL, sf VARCHAR(10) DEFAULT NULL, beds VARCHAR(5) DEFAULT NULL, baths VARCHAR(5) DEFAULT NULL, INDEX IDX_DCBB0C534D2A7E12 (building_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, active_hoa_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, name VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) DEFAULT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649CBA4995B (active_hoa_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_role (user_id INT NOT NULL, role_id INT NOT NULL, INDEX IDX_2DE8C6A3A76ED395 (user_id), INDEX IDX_2DE8C6A3D60322AC (role_id), PRIMARY KEY(user_id, role_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vendor (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, contact_name VARCHAR(255) DEFAULT NULL, contact_number VARCHAR(20) NOT NULL, contact_email VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE building ADD CONSTRAINT FK_E16F61D4D9150B06 FOREIGN KEY (h_oa_id) REFERENCES hoa (id)');
        $this->addSql('ALTER TABLE ledger_account ADD CONSTRAINT FK_B3339695C54C8C93 FOREIGN KEY (type_id) REFERENCES ledger_type (id)');
        $this->addSql('ALTER TABLE ledger_account ADD CONSTRAINT FK_B33396957E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id)');
        $this->addSql('ALTER TABLE ledger_account ADD CONSTRAINT FK_B3339695F603EE73 FOREIGN KEY (vendor_id) REFERENCES vendor (id)');
        $this->addSql('ALTER TABLE ledger_account ADD CONSTRAINT FK_B3339695549D404C FOREIGN KEY (hoa_id) REFERENCES hoa (id)');
        $this->addSql('ALTER TABLE maintenance_object ADD CONSTRAINT FK_82509DE5F603EE73 FOREIGN KEY (vendor_id) REFERENCES vendor (id)');
        $this->addSql('ALTER TABLE maintenance_object ADD CONSTRAINT FK_82509DE5549D404C FOREIGN KEY (hoa_id) REFERENCES hoa (id)');
        $this->addSql('ALTER TABLE owner ADD CONSTRAINT FK_CF60E67CF8BD700D FOREIGN KEY (unit_id) REFERENCES unit (id)');
        $this->addSql('ALTER TABLE owner ADD CONSTRAINT FK_CF60E67CA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D16813E404 FOREIGN KEY (credit_account_id) REFERENCES ledger_account (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1204C4EAA FOREIGN KEY (debit_account_id) REFERENCES ledger_account (id)');
        $this->addSql('ALTER TABLE unit ADD CONSTRAINT FK_DCBB0C534D2A7E12 FOREIGN KEY (building_id) REFERENCES building (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649CBA4995B FOREIGN KEY (active_hoa_id) REFERENCES hoa (id)');
        $this->addSql('ALTER TABLE user_role ADD CONSTRAINT FK_2DE8C6A3A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_role ADD CONSTRAINT FK_2DE8C6A3D60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE unit DROP FOREIGN KEY FK_DCBB0C534D2A7E12');
        $this->addSql('ALTER TABLE building DROP FOREIGN KEY FK_E16F61D4D9150B06');
        $this->addSql('ALTER TABLE ledger_account DROP FOREIGN KEY FK_B3339695549D404C');
        $this->addSql('ALTER TABLE maintenance_object DROP FOREIGN KEY FK_82509DE5549D404C');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649CBA4995B');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D16813E404');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1204C4EAA');
        $this->addSql('ALTER TABLE ledger_account DROP FOREIGN KEY FK_B3339695C54C8C93');
        $this->addSql('ALTER TABLE ledger_account DROP FOREIGN KEY FK_B33396957E3C61F9');
        $this->addSql('ALTER TABLE user_role DROP FOREIGN KEY FK_2DE8C6A3D60322AC');
        $this->addSql('ALTER TABLE owner DROP FOREIGN KEY FK_CF60E67CF8BD700D');
        $this->addSql('ALTER TABLE owner DROP FOREIGN KEY FK_CF60E67CA76ED395');
        $this->addSql('ALTER TABLE user_role DROP FOREIGN KEY FK_2DE8C6A3A76ED395');
        $this->addSql('ALTER TABLE ledger_account DROP FOREIGN KEY FK_B3339695F603EE73');
        $this->addSql('ALTER TABLE maintenance_object DROP FOREIGN KEY FK_82509DE5F603EE73');
        $this->addSql('DROP TABLE building');
        $this->addSql('DROP TABLE hoa');
        $this->addSql('DROP TABLE ledger_account');
        $this->addSql('DROP TABLE ledger_type');
        $this->addSql('DROP TABLE maintenance_object');
        $this->addSql('DROP TABLE owner');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE transaction');
        $this->addSql('DROP TABLE unit');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE user_role');
        $this->addSql('DROP TABLE vendor');
    }
}
