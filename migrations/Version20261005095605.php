<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261005095605 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_building ADD status VARCHAR(20) NOT NULL, ADD create_time DATETIME NOT NULL, ADD finish_time DATETIME NOT NULL, ADD building_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_building ADD CONSTRAINT FK_1E285D44D2A7E12 FOREIGN KEY (building_id) REFERENCES building (id)');
        $this->addSql('CREATE INDEX IDX_1E285D44D2A7E12 ON user_building (building_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_building DROP FOREIGN KEY FK_1E285D44D2A7E12');
        $this->addSql('DROP INDEX IDX_1E285D44D2A7E12 ON user_building');
        $this->addSql('ALTER TABLE user_building DROP status, DROP create_time, DROP finish_time, DROP building_id');
    }
}
