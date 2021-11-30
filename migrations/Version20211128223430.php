<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211128223430 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE action CHANGE id_action id_action VARCHAR(100) NOT NULL');
        $this->addSql('DROP INDEX gmail ON membre');
        $this->addSql('DROP INDEX id_list ON membre');
        $this->addSql('DROP INDEX id_user ON membre');
        $this->addSql('ALTER TABLE membre CHANGE gmail gmail VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE publication CHANGE id_publication id_publication VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE theme ADD image VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE action CHANGE id_action id_action VARCHAR(100) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`');
        $this->addSql('ALTER TABLE membre CHANGE gmail gmail VARCHAR(200) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`');
        $this->addSql('CREATE INDEX gmail ON membre (gmail)');
        $this->addSql('CREATE INDEX id_list ON membre (id_list, id_profil)');
        $this->addSql('CREATE INDEX id_user ON membre (gmail)');
        $this->addSql('ALTER TABLE publication CHANGE id_publication id_publication VARCHAR(100) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`');
        $this->addSql('ALTER TABLE theme DROP image');
    }
}
