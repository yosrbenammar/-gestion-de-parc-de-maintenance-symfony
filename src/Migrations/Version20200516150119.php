<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200516150119 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE entree (id INT AUTO_INCREMENT NOT NULL, piece_rechange_id INT NOT NULL, fournisseur_id INT DEFAULT NULL, date DATETIME NOT NULL, quantite INT NOT NULL, source VARCHAR(100) DEFAULT NULL, INDEX IDX_598377A6C3E2FA61 (piece_rechange_id), INDEX IDX_598377A6670C757F (fournisseur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fournisseur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(20) NOT NULL, tel VARCHAR(8) NOT NULL, adress VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE piece_rechange (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(90) NOT NULL, quantite INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sous_traitant (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(20) NOT NULL, date_debut_contract DATETIME DEFAULT NULL, date_fin_contract DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicule (id INT AUTO_INCREMENT NOT NULL, matricule VARCHAR(20) NOT NULL, type VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE entree ADD CONSTRAINT FK_598377A6C3E2FA61 FOREIGN KEY (piece_rechange_id) REFERENCES piece_rechange (id)');
        $this->addSql('ALTER TABLE entree ADD CONSTRAINT FK_598377A6670C757F FOREIGN KEY (fournisseur_id) REFERENCES fournisseur (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE entree DROP FOREIGN KEY FK_598377A6670C757F');
        $this->addSql('ALTER TABLE entree DROP FOREIGN KEY FK_598377A6C3E2FA61');
        $this->addSql('DROP TABLE entree');
        $this->addSql('DROP TABLE fournisseur');
        $this->addSql('DROP TABLE piece_rechange');
        $this->addSql('DROP TABLE sous_traitant');
        $this->addSql('DROP TABLE vehicule');
    }
}
