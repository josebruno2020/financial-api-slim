<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230908122938 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movements DROP FOREIGN KEY FK_3823752146BF9597');
        $this->addSql('ALTER TABLE movements ADD CONSTRAINT FK_3823752146BF9597 FOREIGN KEY (payment_form_id) REFERENCES payment_forms (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movements DROP FOREIGN KEY FK_3823752146BF9597');
        $this->addSql('ALTER TABLE movements ADD CONSTRAINT FK_3823752146BF9597 FOREIGN KEY (payment_form_id) REFERENCES categories (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
