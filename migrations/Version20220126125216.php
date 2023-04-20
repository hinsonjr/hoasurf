<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220126125216 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD active_hoa_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649CBA4995B FOREIGN KEY (active_hoa_id) REFERENCES hoa (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649CBA4995B ON user (active_hoa_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649CBA4995B');
        $this->addSql('DROP INDEX IDX_8D93D649CBA4995B ON `user`');
        $this->addSql('ALTER TABLE `user` DROP active_hoa_id');
    }
}
