<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211216131548 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE app_entity_accounting_transaction (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE owner_user');
        $this->addSql('ALTER TABLE owner ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE owner ADD CONSTRAINT FK_CF60E67CA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_CF60E67CA76ED395 ON owner (user_id)');
        $this->addSql('ALTER TABLE transaction ADD created_by_id INT NOT NULL, ADD credit_account_id INT NOT NULL, ADD debit_account_id INT NOT NULL, ADD amount NUMERIC(12, 2) NOT NULL');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1B03A8386 FOREIGN KEY (created_by_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D16813E404 FOREIGN KEY (credit_account_id) REFERENCES ledger_account (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1204C4EAA FOREIGN KEY (debit_account_id) REFERENCES transaction (id)');
        $this->addSql('CREATE INDEX IDX_723705D1B03A8386 ON transaction (created_by_id)');
        $this->addSql('CREATE INDEX IDX_723705D16813E404 ON transaction (credit_account_id)');
        $this->addSql('CREATE INDEX IDX_723705D1204C4EAA ON transaction (debit_account_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE owner_user (owner_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_1B35B5D97E3C61F9 (owner_id), INDEX IDX_1B35B5D9A76ED395 (user_id), PRIMARY KEY(owner_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE owner_user ADD CONSTRAINT FK_1B35B5D9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE owner_user ADD CONSTRAINT FK_1B35B5D97E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE app_entity_accounting_transaction');
        $this->addSql('ALTER TABLE owner DROP FOREIGN KEY FK_CF60E67CA76ED395');
        $this->addSql('DROP INDEX IDX_CF60E67CA76ED395 ON owner');
        $this->addSql('ALTER TABLE owner DROP user_id');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1B03A8386');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D16813E404');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1204C4EAA');
        $this->addSql('DROP INDEX IDX_723705D1B03A8386 ON transaction');
        $this->addSql('DROP INDEX IDX_723705D16813E404 ON transaction');
        $this->addSql('DROP INDEX IDX_723705D1204C4EAA ON transaction');
        $this->addSql('ALTER TABLE transaction DROP created_by_id, DROP credit_account_id, DROP debit_account_id, DROP amount');
    }
}
