<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260213082513 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sport_sport_type (sport_id INT NOT NULL, sport_type_id INT NOT NULL, PRIMARY KEY (sport_id, sport_type_id))');
        $this->addSql('CREATE INDEX IDX_C829E6C8AC78BCF8 ON sport_sport_type (sport_id)');
        $this->addSql('CREATE INDEX IDX_C829E6C864F9C039 ON sport_sport_type (sport_type_id)');
        $this->addSql('ALTER TABLE sport_sport_type ADD CONSTRAINT FK_C829E6C8AC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sport_sport_type ADD CONSTRAINT FK_C829E6C864F9C039 FOREIGN KEY (sport_type_id) REFERENCES sport_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sport DROP CONSTRAINT fk_1a85efd264f9c039');
        $this->addSql('DROP INDEX idx_1a85efd264f9c039');
        $this->addSql('ALTER TABLE sport DROP sport_type_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sport_sport_type DROP CONSTRAINT FK_C829E6C8AC78BCF8');
        $this->addSql('ALTER TABLE sport_sport_type DROP CONSTRAINT FK_C829E6C864F9C039');
        $this->addSql('DROP TABLE sport_sport_type');
        $this->addSql('ALTER TABLE sport ADD sport_type_id INT NOT NULL');
        $this->addSql('ALTER TABLE sport ADD CONSTRAINT fk_1a85efd264f9c039 FOREIGN KEY (sport_type_id) REFERENCES sport_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_1a85efd264f9c039 ON sport (sport_type_id)');
    }
}
