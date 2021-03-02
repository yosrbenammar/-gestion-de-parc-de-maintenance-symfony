<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200421170154 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sous_famille (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, marque VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        //  $this->addSql('ALTER TABLE employes CHANGE tel tel VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE machine ADD sous_famille_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE machine ADD CONSTRAINT FK_1505DF8471DF2E6E FOREIGN KEY (sous_famille_id) REFERENCES sous_famille (id)');
        $this->addSql('CREATE INDEX IDX_1505DF8471DF2E6E ON machine (sous_famille_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE machine DROP FOREIGN KEY FK_1505DF8471DF2E6E');
        $this->addSql('DROP TABLE sous_famille');
       // $this->addSql('ALTER TABLE employes CHANGE tel tel VARCHAR(8) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('DROP INDEX IDX_1505DF8471DF2E6E ON machine');
        $this->addSql('ALTER TABLE machine DROP sous_famille_id');
    }
}
