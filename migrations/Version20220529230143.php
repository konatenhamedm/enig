<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220529230143 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE acte (id INT AUTO_INCREMENT NOT NULL, vendeur_id INT DEFAULT NULL, acheteur_id INT DEFAULT NULL, date DATETIME DEFAULT NULL, objet VARCHAR(255) NOT NULL, montant DOUBLE PRECISION NOT NULL, active VARCHAR(255) NOT NULL, numero VARCHAR(255) NOT NULL, detail LONGTEXT NOT NULL, details LONGTEXT DEFAULT NULL, etat_bien VARCHAR(255) NOT NULL, INDEX IDX_9EC41326858C065E (vendeur_id), INDEX IDX_9EC4132696A7BB5F (acheteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE acte_constitution (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, form_id INT DEFAULT NULL, objet VARCHAR(255) DEFAULT NULL, capital DOUBLE PRECISION DEFAULT NULL, devise VARCHAR(255) DEFAULT NULL, nature_action VARCHAR(255) DEFAULT NULL, liberation_souscription VARCHAR(255) DEFAULT NULL, nom_gerant VARCHAR(255) DEFAULT NULL, siege VARCHAR(255) DEFAULT NULL, duree VARCHAR(255) DEFAULT NULL, denomination VARCHAR(255) DEFAULT NULL, active VARCHAR(255) DEFAULT NULL, sigle VARCHAR(255) DEFAULT NULL, etat TINYINT(1) DEFAULT NULL, INDEX IDX_61E0B5F819EB6921 (client_id), INDEX IDX_61E0B5F85FF69B7D (form_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE archive (id INT AUTO_INCREMENT NOT NULL, acte_id INT DEFAULT NULL, path VARCHAR(255) NOT NULL, INDEX IDX_D5FC5D9CA767B8C7 (acte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE calendar (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, start DATETIME NOT NULL, end DATETIME NOT NULL, description LONGTEXT NOT NULL, all_day TINYINT(1) NOT NULL, background_color VARCHAR(7) NOT NULL, border_color VARCHAR(7) NOT NULL, text_color VARCHAR(7) NOT NULL, active VARCHAR(255) NOT NULL, INDEX IDX_6EA9A14619EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, status VARCHAR(255) NOT NULL, active INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, type_client_id INT DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, date_naissance DATETIME DEFAULT NULL, lieu_naissance VARCHAR(255) DEFAULT NULL, profession VARCHAR(255) DEFAULT NULL, domicile VARCHAR(255) DEFAULT NULL, pere VARCHAR(255) DEFAULT NULL, mere VARCHAR(255) DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, tel_domicile VARCHAR(255) DEFAULT NULL, tel_bureau VARCHAR(255) DEFAULT NULL, tel_portable VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, nationalite VARCHAR(255) DEFAULT NULL, situation VARCHAR(255) DEFAULT NULL, nom_conjoint VARCHAR(255) DEFAULT NULL, prenom_conjoint VARCHAR(255) DEFAULT NULL, date_naissance_conjoint DATETIME DEFAULT NULL, lieu_naissance_conjoint VARCHAR(255) DEFAULT NULL, profession_conjoint VARCHAR(255) DEFAULT NULL, pere_conjoint VARCHAR(255) DEFAULT NULL, mere_conjoint VARCHAR(255) DEFAULT NULL, adresse_conjoint VARCHAR(255) DEFAULT NULL, nationalite_conjoint VARCHAR(255) DEFAULT NULL, regime_matrimonial_conjoint VARCHAR(255) DEFAULT NULL, date_mariage DATETIME DEFAULT NULL, lieu_mariage_conjoint VARCHAR(255) DEFAULT NULL, contrat_mariage_conjoint VARCHAR(255) DEFAULT NULL, affirmatif VARCHAR(255) DEFAULT NULL, precedent_mariage VARCHAR(255) DEFAULT NULL, nom_prenom_epoux VARCHAR(255) DEFAULT NULL, date_precedent DATETIME DEFAULT NULL, regime VARCHAR(255) DEFAULT NULL, numero_jugement VARCHAR(255) DEFAULT NULL, date_jugement DATETIME DEFAULT NULL, jugement_rendu VARCHAR(255) DEFAULT NULL, date_deces DATETIME DEFAULT NULL, lieu_deces VARCHAR(255) DEFAULT NULL, fait_le DATETIME DEFAULT NULL, active VARCHAR(255) DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL, email_conjoint VARCHAR(255) DEFAULT NULL, tel_conjoint VARCHAR(255) DEFAULT NULL, portable_conjoint VARCHAR(255) DEFAULT NULL, etat VARCHAR(255) DEFAULT NULL, site_web VARCHAR(255) DEFAULT NULL, raison_social VARCHAR(255) DEFAULT NULL, boite_postal VARCHAR(255) DEFAULT NULL, local VARCHAR(255) DEFAULT NULL, registre_commercial VARCHAR(255) DEFAULT NULL, etat_bien VARCHAR(255) DEFAULT NULL, INDEX IDX_C7440455AD2D2831 (type_client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE courier_arrive (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, recep_id INT DEFAULT NULL, numero VARCHAR(255) NOT NULL, date_reception DATETIME NOT NULL, objet LONGTEXT NOT NULL, categorie VARCHAR(255) NOT NULL, active VARCHAR(255) NOT NULL, etat TINYINT(1) DEFAULT NULL, type VARCHAR(255) NOT NULL, existe TINYINT(1) DEFAULT NULL, rangement VARCHAR(255) NOT NULL, expediteur VARCHAR(255) NOT NULL, INDEX IDX_90FA9925A76ED395 (user_id), INDEX IDX_90FA99257F5413B1 (recep_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE documents (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, libelle VARCHAR(255) DEFAULT NULL, INDEX IDX_A2B07288C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fichier (id INT AUTO_INCREMENT NOT NULL, arrive_id INT DEFAULT NULL, path VARCHAR(255) NOT NULL, titre VARCHAR(255) NOT NULL, INDEX IDX_9B76551FF4028648 (arrive_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fichier_acte (id INT AUTO_INCREMENT NOT NULL, acte_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, INDEX IDX_1F4BDBCDA767B8C7 (acte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fichier_constitution (id INT AUTO_INCREMENT NOT NULL, acte_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, date_obtention DATETIME DEFAULT NULL, path VARCHAR(255) DEFAULT NULL, etat TINYINT(1) NOT NULL, INDEX IDX_DF9C4C29A767B8C7 (acte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe (id INT AUTO_INCREMENT NOT NULL, module_id INT DEFAULT NULL, icon_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, lien VARCHAR(255) NOT NULL, ordre INT NOT NULL, INDEX IDX_4B98C21AFC2B591 (module_id), INDEX IDX_4B98C2154B9D732 (icon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE icons (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, active VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, produit_id INT DEFAULT NULL, image VARCHAR(255) NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_C53D045FF347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE marque (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, logo VARCHAR(255) NOT NULL, active INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE module (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, icon_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, ordre INT NOT NULL, active INT NOT NULL, INDEX IDX_C242628727ACA70 (parent_id), INDEX IDX_C24262854B9D732 (icon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE module_parent (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, ordre INT NOT NULL, active INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parametre (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, logo VARCHAR(255) NOT NULL, couleur_header VARCHAR(255) NOT NULL, couleur_side VARCHAR(255) NOT NULL, active INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partenaire (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, logo VARCHAR(255) NOT NULL, active INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, categorie_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, date_ajout DATE NOT NULL, description LONGTEXT NOT NULL, active INT NOT NULL, INDEX IDX_29A5EC27BCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, active VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_client (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, active VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_societe (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, sigle VARCHAR(255) NOT NULL, active VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenoms VARCHAR(255) NOT NULL, active INT NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE acte ADD CONSTRAINT FK_9EC41326858C065E FOREIGN KEY (vendeur_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE acte ADD CONSTRAINT FK_9EC4132696A7BB5F FOREIGN KEY (acheteur_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE acte_constitution ADD CONSTRAINT FK_61E0B5F819EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE acte_constitution ADD CONSTRAINT FK_61E0B5F85FF69B7D FOREIGN KEY (form_id) REFERENCES type_societe (id)');
        $this->addSql('ALTER TABLE archive ADD CONSTRAINT FK_D5FC5D9CA767B8C7 FOREIGN KEY (acte_id) REFERENCES acte (id)');
        $this->addSql('ALTER TABLE calendar ADD CONSTRAINT FK_6EA9A14619EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455AD2D2831 FOREIGN KEY (type_client_id) REFERENCES type_client (id)');
        $this->addSql('ALTER TABLE courier_arrive ADD CONSTRAINT FK_90FA9925A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE courier_arrive ADD CONSTRAINT FK_90FA99257F5413B1 FOREIGN KEY (recep_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE documents ADD CONSTRAINT FK_A2B07288C54C8C93 FOREIGN KEY (type_id) REFERENCES type_societe (id)');
        $this->addSql('ALTER TABLE fichier ADD CONSTRAINT FK_9B76551FF4028648 FOREIGN KEY (arrive_id) REFERENCES courier_arrive (id)');
        $this->addSql('ALTER TABLE fichier_acte ADD CONSTRAINT FK_1F4BDBCDA767B8C7 FOREIGN KEY (acte_id) REFERENCES acte (id)');
        $this->addSql('ALTER TABLE fichier_constitution ADD CONSTRAINT FK_DF9C4C29A767B8C7 FOREIGN KEY (acte_id) REFERENCES acte_constitution (id)');
        $this->addSql('ALTER TABLE groupe ADD CONSTRAINT FK_4B98C21AFC2B591 FOREIGN KEY (module_id) REFERENCES module (id)');
        $this->addSql('ALTER TABLE groupe ADD CONSTRAINT FK_4B98C2154B9D732 FOREIGN KEY (icon_id) REFERENCES icons (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C242628727ACA70 FOREIGN KEY (parent_id) REFERENCES module_parent (id)');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C24262854B9D732 FOREIGN KEY (icon_id) REFERENCES icons (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE archive DROP FOREIGN KEY FK_D5FC5D9CA767B8C7');
        $this->addSql('ALTER TABLE fichier_acte DROP FOREIGN KEY FK_1F4BDBCDA767B8C7');
        $this->addSql('ALTER TABLE fichier_constitution DROP FOREIGN KEY FK_DF9C4C29A767B8C7');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27BCF5E72D');
        $this->addSql('ALTER TABLE acte DROP FOREIGN KEY FK_9EC41326858C065E');
        $this->addSql('ALTER TABLE acte DROP FOREIGN KEY FK_9EC4132696A7BB5F');
        $this->addSql('ALTER TABLE acte_constitution DROP FOREIGN KEY FK_61E0B5F819EB6921');
        $this->addSql('ALTER TABLE calendar DROP FOREIGN KEY FK_6EA9A14619EB6921');
        $this->addSql('ALTER TABLE courier_arrive DROP FOREIGN KEY FK_90FA99257F5413B1');
        $this->addSql('ALTER TABLE fichier DROP FOREIGN KEY FK_9B76551FF4028648');
        $this->addSql('ALTER TABLE groupe DROP FOREIGN KEY FK_4B98C2154B9D732');
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C24262854B9D732');
        $this->addSql('ALTER TABLE groupe DROP FOREIGN KEY FK_4B98C21AFC2B591');
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C242628727ACA70');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FF347EFB');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455AD2D2831');
        $this->addSql('ALTER TABLE acte_constitution DROP FOREIGN KEY FK_61E0B5F85FF69B7D');
        $this->addSql('ALTER TABLE documents DROP FOREIGN KEY FK_A2B07288C54C8C93');
        $this->addSql('ALTER TABLE courier_arrive DROP FOREIGN KEY FK_90FA9925A76ED395');
        $this->addSql('DROP TABLE acte');
        $this->addSql('DROP TABLE acte_constitution');
        $this->addSql('DROP TABLE archive');
        $this->addSql('DROP TABLE calendar');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE courier_arrive');
        $this->addSql('DROP TABLE documents');
        $this->addSql('DROP TABLE fichier');
        $this->addSql('DROP TABLE fichier_acte');
        $this->addSql('DROP TABLE fichier_constitution');
        $this->addSql('DROP TABLE groupe');
        $this->addSql('DROP TABLE icons');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE marque');
        $this->addSql('DROP TABLE module');
        $this->addSql('DROP TABLE module_parent');
        $this->addSql('DROP TABLE parametre');
        $this->addSql('DROP TABLE partenaire');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE type_client');
        $this->addSql('DROP TABLE type_societe');
        $this->addSql('DROP TABLE user');
    }
}
