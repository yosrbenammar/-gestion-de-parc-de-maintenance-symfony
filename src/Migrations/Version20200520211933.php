<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200520211933 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE demandeIntervention ADD machine_id INT NOT NULL');
        $this->addSql('ALTER TABLE demandeIntervention ADD CONSTRAINT FK_3885B260F6B75B26 FOREIGN KEY (machine_id) REFERENCES machine (id)');
        $this->addSql('CREATE INDEX IDX_3885B260F6B75B26 ON demandeIntervention (machine_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE demandeIntervention DROP FOREIGN KEY FK_3885B260F6B75B26');
        $this->addSql('DROP INDEX IDX_3885B260F6B75B26 ON demandeIntervention');
        $this->addSql('ALTER TABLE demandeIntervention DROP machine_id');
    }
}
