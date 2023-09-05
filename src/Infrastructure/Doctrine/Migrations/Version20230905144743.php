<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230905144743 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__movements AS SELECT id, type, value, date, obs, created_at, updated_at FROM movements');
        $this->addSql('DROP TABLE movements');
        $this->addSql('CREATE TABLE movements (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, category_id INTEGER DEFAULT NULL, type INTEGER NOT NULL, value NUMERIC(10, 0) NOT NULL, date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, obs VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CONSTRAINT FK_3823752112469DE2 FOREIGN KEY (category_id) REFERENCES categories (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO movements (id, type, value, date, obs, created_at, updated_at) SELECT id, type, value, date, obs, created_at, updated_at FROM __temp__movements');
        $this->addSql('DROP TABLE __temp__movements');
        $this->addSql('CREATE INDEX IDX_3823752112469DE2 ON movements (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__movements AS SELECT id, type, value, date, obs, created_at, updated_at FROM movements');
        $this->addSql('DROP TABLE movements');
        $this->addSql('CREATE TABLE movements (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, type INTEGER NOT NULL, value NUMERIC(10, 0) NOT NULL, date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, obs VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL)');
        $this->addSql('INSERT INTO movements (id, type, value, date, obs, created_at, updated_at) SELECT id, type, value, date, obs, created_at, updated_at FROM __temp__movements');
        $this->addSql('DROP TABLE __temp__movements');
    }
}
