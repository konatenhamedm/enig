<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220520003532 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client DROP etat_bien_vendu, CHANGE nom nom VARCHAR(255) DEFAULT NULL, CHANGE prenom prenom VARCHAR(255) DEFAULT NULL, CHANGE date_naissance date_naissance DATETIME DEFAULT NULL, CHANGE lieu_naissance lieu_naissance VARCHAR(255) DEFAULT NULL, CHANGE tel_portable tel_portable VARCHAR(255) DEFAULT NULL, CHANGE etat etat VARCHAR(255) DEFAULT NULL, CHANGE boite_postal boite_postal VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client ADD etat_bien_vendu VARCHAR(255) DEFAULT NULL, CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE prenom prenom VARCHAR(255) NOT NULL, CHANGE date_naissance date_naissance DATETIME NOT NULL, CHANGE lieu_naissance lieu_naissance VARCHAR(255) NOT NULL, CHANGE tel_portable tel_portable VARCHAR(255) NOT NULL, CHANGE etat etat VARCHAR(255) NOT NULL, CHANGE boite_postal boite_postal VARCHAR(255) NOT NULL');
    }
}
