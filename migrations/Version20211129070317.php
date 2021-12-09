<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211129070317 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE action CHANGE id_action id_action VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE publication CHANGE id_publication id_publication VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE theme CHANGE email email VARCHAR(100) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX nomTheme ON theme (nom_theme)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE action CHANGE id_action id_action VARCHAR(100) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`');
        $this->addSql('ALTER TABLE publication CHANGE id_publication id_publication VARCHAR(100) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`');
        $this->addSql('DROP INDEX nomTheme ON theme');
        $this->addSql('ALTER TABLE theme CHANGE email email VARCHAR(200) CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`');
    }
}