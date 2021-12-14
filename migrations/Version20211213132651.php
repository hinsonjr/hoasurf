<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211213132651 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ledger_account (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, balance NUMERIC(12, 2) DEFAULT \'0\' NOT NULL, start_balance NUMERIC(12, 2) DEFAULT \'0\' NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ledger_account_ledger_type (ledger_account_id INT NOT NULL, ledger_type_id INT NOT NULL, INDEX IDX_3CD5A50C552F312 (ledger_account_id), INDEX IDX_3CD5A50CB494CA2 (ledger_type_id), PRIMARY KEY(ledger_account_id, ledger_type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ledger_account_hoa (ledger_account_id INT NOT NULL, hoa_id INT NOT NULL, INDEX IDX_F93D2E04552F312 (ledger_account_id), INDEX IDX_F93D2E04549D404C (hoa_id), PRIMARY KEY(ledger_account_id, hoa_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ledger_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(24) NOT NULL, is_debit TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE owner_account (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, category VARCHAR(25) NOT NULL, balance NUMERIC(12, 2) DEFAULT \'0\' NOT NULL, start_balance NUMERIC(12, 2) DEFAULT \'0\' NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE owner_account_owner (owner_account_id INT NOT NULL, owner_id INT NOT NULL, INDEX IDX_825AC961C901C6FF (owner_account_id), INDEX IDX_825AC9617E3C61F9 (owner_id), PRIMARY KEY(owner_account_id, owner_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE owner_invoice (id INT AUTO_INCREMENT NOT NULL, category VARCHAR(25) NOT NULL, description VARCHAR(255) DEFAULT NULL, amount NUMERIC(12, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE owner_invoice_hoa (owner_invoice_id INT NOT NULL, hoa_id INT NOT NULL, INDEX IDX_CF40D5697BE368B8 (owner_invoice_id), INDEX IDX_CF40D569549D404C (hoa_id), PRIMARY KEY(owner_invoice_id, hoa_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE owner_invoice_owner (owner_invoice_id INT NOT NULL, owner_id INT NOT NULL, INDEX IDX_890F40A57BE368B8 (owner_invoice_id), INDEX IDX_890F40A57E3C61F9 (owner_id), PRIMARY KEY(owner_invoice_id, owner_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ledger_account_ledger_type ADD CONSTRAINT FK_3CD5A50C552F312 FOREIGN KEY (ledger_account_id) REFERENCES ledger_account (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ledger_account_ledger_type ADD CONSTRAINT FK_3CD5A50CB494CA2 FOREIGN KEY (ledger_type_id) REFERENCES ledger_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ledger_account_hoa ADD CONSTRAINT FK_F93D2E04552F312 FOREIGN KEY (ledger_account_id) REFERENCES ledger_account (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ledger_account_hoa ADD CONSTRAINT FK_F93D2E04549D404C FOREIGN KEY (hoa_id) REFERENCES hoa (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE owner_account_owner ADD CONSTRAINT FK_825AC961C901C6FF FOREIGN KEY (owner_account_id) REFERENCES owner_account (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE owner_account_owner ADD CONSTRAINT FK_825AC9617E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE owner_invoice_hoa ADD CONSTRAINT FK_CF40D5697BE368B8 FOREIGN KEY (owner_invoice_id) REFERENCES owner_invoice (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE owner_invoice_hoa ADD CONSTRAINT FK_CF40D569549D404C FOREIGN KEY (hoa_id) REFERENCES hoa (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE owner_invoice_owner ADD CONSTRAINT FK_890F40A57BE368B8 FOREIGN KEY (owner_invoice_id) REFERENCES owner_invoice (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE owner_invoice_owner ADD CONSTRAINT FK_890F40A57E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE maintenance_object ADD CONSTRAINT FK_82509DE5549D404C FOREIGN KEY (hoa_id) REFERENCES hoa (id)');
        $this->addSql('CREATE INDEX IDX_82509DE5549D404C ON maintenance_object (hoa_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ledger_account_ledger_type DROP FOREIGN KEY FK_3CD5A50C552F312');
        $this->addSql('ALTER TABLE ledger_account_hoa DROP FOREIGN KEY FK_F93D2E04552F312');
        $this->addSql('ALTER TABLE ledger_account_ledger_type DROP FOREIGN KEY FK_3CD5A50CB494CA2');
        $this->addSql('ALTER TABLE owner_account_owner DROP FOREIGN KEY FK_825AC961C901C6FF');
        $this->addSql('ALTER TABLE owner_invoice_hoa DROP FOREIGN KEY FK_CF40D5697BE368B8');
        $this->addSql('ALTER TABLE owner_invoice_owner DROP FOREIGN KEY FK_890F40A57BE368B8');
        $this->addSql('DROP TABLE ledger_account');
        $this->addSql('DROP TABLE ledger_account_ledger_type');
        $this->addSql('DROP TABLE ledger_account_hoa');
        $this->addSql('DROP TABLE ledger_type');
        $this->addSql('DROP TABLE owner_account');
        $this->addSql('DROP TABLE owner_account_owner');
        $this->addSql('DROP TABLE owner_invoice');
        $this->addSql('DROP TABLE owner_invoice_hoa');
        $this->addSql('DROP TABLE owner_invoice_owner');
        $this->addSql('DROP TABLE transaction');
        $this->addSql('ALTER TABLE maintenance_object DROP FOREIGN KEY FK_82509DE5549D404C');
        $this->addSql('DROP INDEX IDX_82509DE5549D404C ON maintenance_object');
    }
}
