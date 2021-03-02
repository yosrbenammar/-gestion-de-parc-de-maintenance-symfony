<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200527220736 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE technicien ADD role VARCHAR(255) NOT NULL');
        $this->addSql('DROP INDEX uniq_96282c4cf037ab0f ON technicien');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D9752F9CF037AB0F ON technicien (tel)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `Technicien` DROP role');
        $this->addSql('DROP INDEX uniq_d9752f9cf037ab0f ON `Technicien`');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_96282C4CF037AB0F ON `Technicien` (tel)');
    }
}
