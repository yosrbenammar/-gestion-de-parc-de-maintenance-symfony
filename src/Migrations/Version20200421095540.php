<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200421095540 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE emplacement (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
       // $this->addSql('ALTER TABLE employes DROP INDEX tel, ADD UNIQUE INDEX UNIQ_A94BC0F0F037AB0F (tel)');
       // $this->addSql('DROP INDEX tel_2 ON employes');
       // $this->addSql('ALTER TABLE employes CHANGE tel tel VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE historique_emplacement ADD emplacement_id INT NOT NULL');
        $this->addSql('ALTER TABLE historique_emplacement ADD CONSTRAINT FK_19616B90C4598A51 FOREIGN KEY (emplacement_id) REFERENCES emplacement (id)');
        $this->addSql('CREATE INDEX IDX_19616B90C4598A51 ON historique_emplacement (emplacement_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE historique_emplacement DROP FOREIGN KEY FK_19616B90C4598A51');
        $this->addSql('DROP TABLE emplacement');
      //  $this->addSql('ALTER TABLE employes DROP INDEX UNIQ_A94BC0F0F037AB0F, ADD INDEX tel (tel)');
       // $this->addSql('ALTER TABLE employes CHANGE tel tel VARCHAR(8) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
       // $this->addSql('CREATE INDEX tel_2 ON employes (tel)');
        $this->addSql('DROP INDEX IDX_19616B90C4598A51 ON historique_emplacement');
        $this->addSql('ALTER TABLE historique_emplacement DROP emplacement_id');
    }
}
