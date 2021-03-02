<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200522002903 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE intervention (id INT AUTO_INCREMENT NOT NULL, vehicule_id INT DEFAULT NULL, sous_traitant_id INT DEFAULT NULL, chef_equipe_technicien_id INT DEFAULT NULL, titre VARCHAR(100) NOT NULL, desription VARCHAR(255) NOT NULL, etat VARCHAR(20) NOT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, INDEX IDX_D11814AB4A4A3511 (vehicule_id), INDEX IDX_D11814AB9395527E (sous_traitant_id), INDEX IDX_D11814ABD504140E (chef_equipe_technicien_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE intervention_technicien (intervention_id INT NOT NULL, technicien_id INT NOT NULL, INDEX IDX_D4D556418EAE3863 (intervention_id), INDEX IDX_D4D5564113457256 (technicien_id), PRIMARY KEY(intervention_id, technicien_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE technicien (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, fonction VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, tel VARCHAR(8) NOT NULL, date_naissance DATETIME NOT NULL, date_recrutement DATETIME NOT NULL, UNIQUE INDEX UNIQ_96282C4CF037AB0F (tel), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE intervention ADD CONSTRAINT FK_D11814AB4A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicule (id)');
        $this->addSql('ALTER TABLE intervention ADD CONSTRAINT FK_D11814AB9395527E FOREIGN KEY (sous_traitant_id) REFERENCES sous_traitant (id)');
        $this->addSql('ALTER TABLE intervention ADD CONSTRAINT FK_D11814ABD504140E FOREIGN KEY (chef_equipe_technicien_id) REFERENCES technicien (id)');
        $this->addSql('ALTER TABLE intervention_technicien ADD CONSTRAINT FK_D4D556418EAE3863 FOREIGN KEY (intervention_id) REFERENCES intervention (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE intervention_technicien ADD CONSTRAINT FK_D4D5564113457256 FOREIGN KEY (technicien_id) REFERENCES technicien (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE intervention_technicien DROP FOREIGN KEY FK_D4D556418EAE3863');
        $this->addSql('ALTER TABLE intervention DROP FOREIGN KEY FK_D11814ABD504140E');
        $this->addSql('ALTER TABLE intervention_technicien DROP FOREIGN KEY FK_D4D5564113457256');
        $this->addSql('DROP TABLE intervention');
        $this->addSql('DROP TABLE intervention_technicien');
        $this->addSql('DROP TABLE technicien');
    }
}
