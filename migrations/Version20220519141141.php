<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220519141141 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_client (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE acte ADD type_acte_id INT DEFAULT NULL, CHANGE type etat_bien VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE acte ADD CONSTRAINT FK_9EC413268F46D732 FOREIGN KEY (type_acte_id) REFERENCES type (id)');
        $this->addSql('CREATE INDEX IDX_9EC413268F46D732 ON acte (type_acte_id)');
        $this->addSql('ALTER TABLE client ADD type_client_id INT DEFAULT NULL, ADD site_web VARCHAR(255) DEFAULT NULL, ADD raison_social VARCHAR(255) DEFAULT NULL, ADD boite_postal VARCHAR(255) NOT NULL, ADD local VARCHAR(255) DEFAULT NULL, ADD registre_commercial VARCHAR(255) DEFAULT NULL, ADD etat_bien VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455AD2D2831 FOREIGN KEY (type_client_id) REFERENCES type_client (id)');
        $this->addSql('CREATE INDEX IDX_C7440455AD2D2831 ON client (type_client_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE acte DROP FOREIGN KEY FK_9EC413268F46D732');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455AD2D2831');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE type_client');
        $this->addSql('DROP INDEX IDX_9EC413268F46D732 ON acte');
        $this->addSql('ALTER TABLE acte DROP type_acte_id, CHANGE etat_bien type VARCHAR(255) NOT NULL');
        $this->addSql('DROP INDEX IDX_C7440455AD2D2831 ON client');
        $this->addSql('ALTER TABLE client DROP type_client_id, DROP site_web, DROP raison_social, DROP boite_postal, DROP local, DROP registre_commercial, DROP etat_bien');
    }
}
