<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220523104450 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE acte_constitution CHANGE objet objet VARCHAR(255) DEFAULT NULL, CHANGE capital capital DOUBLE PRECISION DEFAULT NULL, CHANGE devise devise VARCHAR(255) DEFAULT NULL, CHANGE nom_gerant nom_gerant VARCHAR(255) DEFAULT NULL, CHANGE siege siege VARCHAR(255) DEFAULT NULL, CHANGE duree duree VARCHAR(255) DEFAULT NULL, CHANGE denomination denomination VARCHAR(255) DEFAULT NULL, CHANGE active active VARCHAR(255) DEFAULT NULL, CHANGE sigle sigle VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE acte_constitution CHANGE objet objet VARCHAR(255) NOT NULL, CHANGE capital capital DOUBLE PRECISION NOT NULL, CHANGE devise devise VARCHAR(255) NOT NULL, CHANGE nom_gerant nom_gerant VARCHAR(255) NOT NULL, CHANGE siege siege VARCHAR(255) NOT NULL, CHANGE duree duree VARCHAR(255) NOT NULL, CHANGE denomination denomination VARCHAR(255) NOT NULL, CHANGE active active VARCHAR(255) NOT NULL, CHANGE sigle sigle VARCHAR(255) NOT NULL');
    }
}
