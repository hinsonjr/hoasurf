<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211216143802 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE owner DROP FOREIGN KEY FK_CF60E67CA76ED395');
        $this->addSql('DROP INDEX IDX_CF60E67CA76ED395 ON owner');
        $this->addSql('ALTER TABLE owner DROP user_id');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1B03A8386');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1204C4EAA');
        $this->addSql('DROP INDEX IDX_723705D1B03A8386 ON transaction');
        $this->addSql('ALTER TABLE transaction DROP created_by_id');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1204C4EAA FOREIGN KEY (debit_account_id) REFERENCES ledger_account (id)');
        $this->addSql('ALTER TABLE user ADD owner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6497E3C61F9 FOREIGN KEY (owner_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6497E3C61F9 ON user (owner_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE owner ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE owner ADD CONSTRAINT FK_CF60E67CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_CF60E67CA76ED395 ON owner (user_id)');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1204C4EAA');
        $this->addSql('ALTER TABLE transaction ADD created_by_id INT NOT NULL');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1204C4EAA FOREIGN KEY (debit_account_id) REFERENCES transaction (id)');
        $this->addSql('CREATE INDEX IDX_723705D1B03A8386 ON transaction (created_by_id)');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D6497E3C61F9');
        $this->addSql('DROP INDEX IDX_8D93D6497E3C61F9 ON `user`');
        $this->addSql('ALTER TABLE `user` DROP owner_id');
    }
}
