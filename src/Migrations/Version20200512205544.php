<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200512205544 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE historique_emplacement DROP FOREIGN KEY FK_19616B90C4598A51');
        $this->addSql('DROP INDEX IDX_19616B90C4598A51 ON historique_emplacement');
        $this->addSql('ALTER TABLE historique_emplacement ADD emplacement LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:object)\', DROP emplacement_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE historique_emplacement ADD emplacement_id INT DEFAULT NULL, DROP emplacement');
        $this->addSql('ALTER TABLE historique_emplacement ADD CONSTRAINT FK_19616B90C4598A51 FOREIGN KEY (emplacement_id) REFERENCES emplacement (id)');
        $this->addSql('CREATE INDEX IDX_19616B90C4598A51 ON historique_emplacement (emplacement_id)');
    }
}
