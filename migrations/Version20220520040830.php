<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220520040830 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE courier_arrive DROP FOREIGN KEY FK_90FA9925D26628FA');
        $this->addSql('ALTER TABLE courier_arrive DROP FOREIGN KEY FK_90FA992510335F61');
        $this->addSql('DROP INDEX IDX_90FA9925D26628FA ON courier_arrive');
        $this->addSql('DROP INDEX IDX_90FA992510335F61 ON courier_arrive');
        $this->addSql('ALTER TABLE courier_arrive ADD expediteur VARCHAR(255) NOT NULL, DROP exp_id, DROP expediteur_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE courier_arrive ADD exp_id INT DEFAULT NULL, ADD expediteur_id INT DEFAULT NULL, DROP expediteur');
        $this->addSql('ALTER TABLE courier_arrive ADD CONSTRAINT FK_90FA9925D26628FA FOREIGN KEY (exp_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE courier_arrive ADD CONSTRAINT FK_90FA992510335F61 FOREIGN KEY (expediteur_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_90FA9925D26628FA ON courier_arrive (exp_id)');
        $this->addSql('CREATE INDEX IDX_90FA992510335F61 ON courier_arrive (expediteur_id)');
    }
}
