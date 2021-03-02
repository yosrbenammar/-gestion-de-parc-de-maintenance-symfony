<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200510205303 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE historique_emplacement ADD machine_id INT DEFAULT NULL, DROP libelle');
        $this->addSql('ALTER TABLE historique_emplacement ADD CONSTRAINT FK_19616B90F6B75B26 FOREIGN KEY (machine_id) REFERENCES machine (id)');
        $this->addSql('CREATE INDEX IDX_19616B90F6B75B26 ON historique_emplacement (machine_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE historique_emplacement DROP FOREIGN KEY FK_19616B90F6B75B26');
        $this->addSql('DROP INDEX IDX_19616B90F6B75B26 ON historique_emplacement');
        $this->addSql('ALTER TABLE historique_emplacement ADD libelle INT NOT NULL, DROP machine_id');
    }
}
