<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220522213844 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fichier_constitution (id INT AUTO_INCREMENT NOT NULL, acte_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, date_obtention DATETIME NOT NULL, path VARCHAR(255) NOT NULL, INDEX IDX_DF9C4C29A767B8C7 (acte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fichier_constitution ADD CONSTRAINT FK_DF9C4C29A767B8C7 FOREIGN KEY (acte_id) REFERENCES acte_constitution (id)');
        $this->addSql('ALTER TABLE acte_constitution ADD client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE acte_constitution ADD CONSTRAINT FK_61E0B5F819EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_61E0B5F819EB6921 ON acte_constitution (client_id)');
        $this->addSql('ALTER TABLE documents DROP date_obtention, DROP path');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE fichier_constitution');
        $this->addSql('ALTER TABLE acte_constitution DROP FOREIGN KEY FK_61E0B5F819EB6921');
        $this->addSql('DROP INDEX IDX_61E0B5F819EB6921 ON acte_constitution');
        $this->addSql('ALTER TABLE acte_constitution DROP client_id');
        $this->addSql('ALTER TABLE documents ADD date_obtention DATETIME DEFAULT NULL, ADD path VARCHAR(255) DEFAULT NULL');
    }
}
