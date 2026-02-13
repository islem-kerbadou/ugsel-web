<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260213081627 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE championship ADD competition_id INT NOT NULL');
        $this->addSql('ALTER TABLE championship ADD CONSTRAINT FK_EBADDE6A7B39D312 FOREIGN KEY (competition_id) REFERENCES competition (id) NOT DEFERRABLE');
        $this->addSql('CREATE INDEX IDX_EBADDE6A7B39D312 ON championship (competition_id)');
        $this->addSql('ALTER TABLE competition ADD sport_id INT NOT NULL');
        $this->addSql('ALTER TABLE competition ADD CONSTRAINT FK_B50A2CB1AC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id) NOT DEFERRABLE');
        $this->addSql('CREATE INDEX IDX_B50A2CB1AC78BCF8 ON competition (sport_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE championship DROP CONSTRAINT FK_EBADDE6A7B39D312');
        $this->addSql('DROP INDEX IDX_EBADDE6A7B39D312');
        $this->addSql('ALTER TABLE championship DROP competition_id');
        $this->addSql('ALTER TABLE competition DROP CONSTRAINT FK_B50A2CB1AC78BCF8');
        $this->addSql('DROP INDEX IDX_B50A2CB1AC78BCF8');
        $this->addSql('ALTER TABLE competition DROP sport_id');
    }
}
