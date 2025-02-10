<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250210143301 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs

        // enum is not supported by doctrine
        $this->addSql("CREATE TABLE task (
            id INT AUTO_INCREMENT NOT NULL,
            title LONGTEXT NOT NULL,
            description LONGTEXT NOT NULL,
            status varchar(20) NOT NULL default 'new',
            created_at DATETIME NOT NULL COMMENT '(DC2Type:datetimetz_immutable)' default CURRENT_TIMESTAMP,
            updated_at DATETIME NOT NULL COMMENT '(DC2Type:datetimetz_immutable)' default CURRENT_TIMESTAMP,
            PRIMARY KEY(id)
        )
        ");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE task');
    }
}
