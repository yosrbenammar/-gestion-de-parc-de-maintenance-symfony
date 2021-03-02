<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200522011524 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE piece_pour_intervention (id INT AUTO_INCREMENT NOT NULL, piece_id INT DEFAULT NULL, quantite INT NOT NULL, INDEX IDX_A8458EA8C40FCFA8 (piece_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE piece_pour_intervention_intervention (piece_pour_intervention_id INT NOT NULL, intervention_id INT NOT NULL, INDEX IDX_563288FB129CC99A (piece_pour_intervention_id), INDEX IDX_563288FB8EAE3863 (intervention_id), PRIMARY KEY(piece_pour_intervention_id, intervention_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE piece_pour_intervention ADD CONSTRAINT FK_A8458EA8C40FCFA8 FOREIGN KEY (piece_id) REFERENCES piece_rechange (id)');
        $this->addSql('ALTER TABLE piece_pour_intervention_intervention ADD CONSTRAINT FK_563288FB129CC99A FOREIGN KEY (piece_pour_intervention_id) REFERENCES piece_pour_intervention (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE piece_pour_intervention_intervention ADD CONSTRAINT FK_563288FB8EAE3863 FOREIGN KEY (intervention_id) REFERENCES intervention (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE piece_pour_intervention_intervention DROP FOREIGN KEY FK_563288FB129CC99A');
        $this->addSql('DROP TABLE piece_pour_intervention');
        $this->addSql('DROP TABLE piece_pour_intervention_intervention');
    }
}
