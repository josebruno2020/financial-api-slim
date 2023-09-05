<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230905021036 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__categories AS SELECT id, name, created_at FROM categories');
        $this->addSql('DROP TABLE categories');
        $this->addSql('CREATE TABLE categories (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO categories (id, name, created_at) SELECT id, name, created_at FROM __temp__categories');
        $this->addSql('DROP TABLE __temp__categories');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__categories AS SELECT id, name, created_at FROM categories');
        $this->addSql('DROP TABLE categories');
        $this->addSql('CREATE TABLE categories (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO categories (id, name, created_at) SELECT id, name, created_at FROM __temp__categories');
        $this->addSql('DROP TABLE __temp__categories');
    }
}
