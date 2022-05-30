<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220522223212 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE acte_constitution ADD form_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE acte_constitution ADD CONSTRAINT FK_61E0B5F85FF69B7D FOREIGN KEY (form_id) REFERENCES type_societe (id)');
        $this->addSql('CREATE INDEX IDX_61E0B5F85FF69B7D ON acte_constitution (form_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE acte_constitution DROP FOREIGN KEY FK_61E0B5F85FF69B7D');
        $this->addSql('DROP INDEX IDX_61E0B5F85FF69B7D ON acte_constitution');
        $this->addSql('ALTER TABLE acte_constitution DROP form_id');
    }
}
