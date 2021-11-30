<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211129062548 extends AbstractMigration
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
        $this->addSql('DROP INDEX id_theme ON theme_membre');
        $this->addSql('ALTER TABLE theme_membre CHANGE gmail gmail VARCHAR(250) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE action CHANGE id_action id_action VARCHAR(100) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`');
        $this->addSql('ALTER TABLE publication CHANGE id_publication id_publication VARCHAR(100) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`');
        $this->addSql('ALTER TABLE theme_membre CHANGE gmail gmail VARCHAR(200) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`');
        $this->addSql('CREATE INDEX id_theme ON theme_membre (id_theme)');
    }
}
