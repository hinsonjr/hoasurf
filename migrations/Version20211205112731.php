<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211205112731 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE owner ADD name VARCHAR(200) NOT NULL, ADD address1 VARCHAR(80) DEFAULT NULL, ADD address VARCHAR(100) DEFAULT NULL, ADD address2 VARCHAR(80) DEFAULT NULL, ADD city VARCHAR(100) DEFAULT NULL, ADD state VARCHAR(50) DEFAULT NULL, ADD zip VARCHAR(10) DEFAULT NULL, DROP firstname, DROP lastname');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE owner ADD firstname VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD lastname VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP name, DROP address1, DROP address, DROP address2, DROP city, DROP state, DROP zip');
    }
}
