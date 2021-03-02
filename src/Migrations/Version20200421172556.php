<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200421172556 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE famille (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, dimension DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
       // $this->addSql('ALTER TABLE employes CHANGE tel tel VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE sous_famille ADD fam_id INT NOT NULL');
        $this->addSql('ALTER TABLE sous_famille ADD CONSTRAINT FK_77A8A5E9B7120E5 FOREIGN KEY (fam_id) REFERENCES famille (id)');
        $this->addSql('CREATE INDEX IDX_77A8A5E9B7120E5 ON sous_famille (fam_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sous_famille DROP FOREIGN KEY FK_77A8A5E9B7120E5');
        $this->addSql('DROP TABLE famille');
     //   $this->addSql('ALTER TABLE employes CHANGE tel tel VARCHAR(8) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('DROP INDEX IDX_77A8A5E9B7120E5 ON sous_famille');
        $this->addSql('ALTER TABLE sous_famille DROP fam_id');
    }
}
