<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240722115138 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__gite AS SELECT id, proprietaire_id, contact_id, nom, adresse, region, departement, ville, surface_habitable, nombre_chambre, nombre_couchage, tarif_hebdo, accepte_animaux FROM gite');
        $this->addSql('DROP TABLE gite');
        $this->addSql('CREATE TABLE gite (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, proprietaire_id INTEGER NOT NULL, contact_id INTEGER NOT NULL, nom VARCHAR(100) NOT NULL, adresse VARCHAR(255) NOT NULL, region VARCHAR(50) NOT NULL, departement VARCHAR(50) NOT NULL, ville VARCHAR(100) NOT NULL, surface_habitable DOUBLE PRECISION NOT NULL, nombre_chambre INTEGER NOT NULL, nombre_couchage INTEGER NOT NULL, tarif_hebdo DOUBLE PRECISION NOT NULL, accepte_animaux BOOLEAN NOT NULL, CONSTRAINT FK_B638C92C76C50E4A FOREIGN KEY (proprietaire_id) REFERENCES proprietaire (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B638C92CE7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO gite (id, proprietaire_id, contact_id, nom, adresse, region, departement, ville, surface_habitable, nombre_chambre, nombre_couchage, tarif_hebdo, accepte_animaux) SELECT id, proprietaire_id, contact_id, nom, adresse, region, departement, ville, surface_habitable, nombre_chambre, nombre_couchage, tarif_hebdo, accepte_animaux FROM __temp__gite');
        $this->addSql('DROP TABLE __temp__gite');
        $this->addSql('CREATE INDEX IDX_B638C92CE7A1254A ON gite (contact_id)');
        $this->addSql('CREATE INDEX IDX_B638C92C76C50E4A ON gite (proprietaire_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gite ADD COLUMN equipement CLOB NOT NULL');
        $this->addSql('ALTER TABLE gite ADD COLUMN services CLOB NOT NULL');
    }
}
