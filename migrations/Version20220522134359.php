<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220522134359 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE acte_constitution (id INT AUTO_INCREMENT NOT NULL, objet VARCHAR(255) NOT NULL, capital DOUBLE PRECISION NOT NULL, devise VARCHAR(255) NOT NULL, nature_action VARCHAR(255) NOT NULL, liberation_souscription VARCHAR(255) NOT NULL, nom_gerant VARCHAR(255) NOT NULL, siege VARCHAR(255) NOT NULL, duree VARCHAR(255) NOT NULL, denomination VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE documents (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, date_obtention DATETIME DEFAULT NULL, path VARCHAR(255) DEFAULT NULL, INDEX IDX_A2B07288C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_societe (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, sigle VARCHAR(255) NOT NULL, active VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE documents ADD CONSTRAINT FK_A2B07288C54C8C93 FOREIGN KEY (type_id) REFERENCES type_societe (id)');
        $this->addSql('ALTER TABLE acte DROP FOREIGN KEY FK_9EC413268F46D732');
        $this->addSql('DROP INDEX IDX_9EC413268F46D732 ON acte');
        $this->addSql('ALTER TABLE acte DROP type_acte_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE documents DROP FOREIGN KEY FK_A2B07288C54C8C93');
        $this->addSql('DROP TABLE acte_constitution');
        $this->addSql('DROP TABLE documents');
        $this->addSql('DROP TABLE type_societe');
        $this->addSql('ALTER TABLE acte ADD type_acte_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE acte ADD CONSTRAINT FK_9EC413268F46D732 FOREIGN KEY (type_acte_id) REFERENCES type (id)');
        $this->addSql('CREATE INDEX IDX_9EC413268F46D732 ON acte (type_acte_id)');
    }
}
