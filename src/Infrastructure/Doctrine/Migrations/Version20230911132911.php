<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230911132911 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE group_invitations (id INT AUTO_INCREMENT NOT NULL, group_id INT DEFAULT NULL, email VARCHAR(255) NOT NULL, status VARCHAR(255) DEFAULT \'pending\' NOT NULL, created_at DATETIME DEFAULT NULL, INDEX IDX_69F0F6FFE54D947 (group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `groups` (id INT AUTO_INCREMENT NOT NULL, created_by INT DEFAULT NULL, name VARCHAR(255) NOT NULL, `description` VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_F06D3970DE12AB56 (created_by), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_groups (group_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_FF8AB7E0FE54D947 (group_id), INDEX IDX_FF8AB7E0A76ED395 (user_id), PRIMARY KEY(group_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE group_invitations ADD CONSTRAINT FK_69F0F6FFE54D947 FOREIGN KEY (group_id) REFERENCES `groups` (id)');
        $this->addSql('ALTER TABLE `groups` ADD CONSTRAINT FK_F06D3970DE12AB56 FOREIGN KEY (created_by) REFERENCES users (id)');
        $this->addSql('ALTER TABLE users_groups ADD CONSTRAINT FK_FF8AB7E0FE54D947 FOREIGN KEY (group_id) REFERENCES `groups` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_groups ADD CONSTRAINT FK_FF8AB7E0A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE group_invitations DROP FOREIGN KEY FK_69F0F6FFE54D947');
        $this->addSql('ALTER TABLE `groups` DROP FOREIGN KEY FK_F06D3970DE12AB56');
        $this->addSql('ALTER TABLE users_groups DROP FOREIGN KEY FK_FF8AB7E0FE54D947');
        $this->addSql('ALTER TABLE users_groups DROP FOREIGN KEY FK_FF8AB7E0A76ED395');
        $this->addSql('DROP TABLE group_invitations');
        $this->addSql('DROP TABLE `groups`');
        $this->addSql('DROP TABLE users_groups');
    }
}
