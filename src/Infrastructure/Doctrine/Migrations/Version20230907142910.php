<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230907142910 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE payment_forms (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE movements ADD payment_form_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE movements ADD CONSTRAINT FK_3823752146BF9597 FOREIGN KEY (payment_form_id) REFERENCES categories (id)');
        $this->addSql('CREATE INDEX IDX_3823752146BF9597 ON movements (payment_form_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE payment_forms');
        $this->addSql('ALTER TABLE movements DROP FOREIGN KEY FK_3823752146BF9597');
        $this->addSql('DROP INDEX IDX_3823752146BF9597 ON movements');
        $this->addSql('ALTER TABLE movements DROP payment_form_id');
    }
}
