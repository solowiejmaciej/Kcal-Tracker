<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240525200317 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE meal_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE settings_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE meal (id INT NOT NULL, kcal INT NOT NULL, protein INT NOT NULL, fat INT NOT NULL, carbs INT NOT NULL, section VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE settings (id INT NOT NULL, max_kcal INT NOT NULL, max_protein INT NOT NULL, max_carbs INT NOT NULL, max_fat INT NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE meal_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE settings_id_seq CASCADE');
        $this->addSql('DROP TABLE meal');
        $this->addSql('DROP TABLE settings');
    }
}
