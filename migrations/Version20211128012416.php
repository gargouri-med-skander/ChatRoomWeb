<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211128012416 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE action CHANGE id_action id_action VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE admin CHANGE num_poste num_poste INT NOT NULL, CHANGE adresse adresse VARCHAR(250) NOT NULL');
        $this->addSql('DROP INDEX gmail ON membre');
        $this->addSql('ALTER TABLE membre ADD id_user INT NOT NULL, DROP gmail');
        $this->addSql('CREATE INDEX id_user ON membre (id_user)');
        $this->addSql('ALTER TABLE publication CHANGE id_publication id_publication VARCHAR(100) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE action CHANGE id_action id_action VARCHAR(100) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`');
        $this->addSql('ALTER TABLE admin CHANGE num_poste num_poste INT DEFAULT NULL, CHANGE adresse adresse VARCHAR(250) CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`');
        $this->addSql('DROP INDEX id_user ON membre');
        $this->addSql('ALTER TABLE membre ADD gmail VARCHAR(200) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, DROP id_user');
        $this->addSql('CREATE INDEX gmail ON membre (gmail)');
        $this->addSql('ALTER TABLE publication CHANGE id_publication id_publication VARCHAR(100) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`');
    }
}
