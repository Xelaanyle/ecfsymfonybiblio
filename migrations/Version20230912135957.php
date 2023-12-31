<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230912135957 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE emprunteur ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE emprunteur ADD CONSTRAINT FK_952067DEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_952067DEA76ED395 ON emprunteur (user_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649F0840037');
        $this->addSql('DROP INDEX UNIQ_8D93D649F0840037 ON user');
        $this->addSql('ALTER TABLE user DROP emprunteur_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD emprunteur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649F0840037 FOREIGN KEY (emprunteur_id) REFERENCES emprunteur (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F0840037 ON user (emprunteur_id)');
        $this->addSql('ALTER TABLE emprunteur DROP FOREIGN KEY FK_952067DEA76ED395');
        $this->addSql('DROP INDEX UNIQ_952067DEA76ED395 ON emprunteur');
        $this->addSql('ALTER TABLE emprunteur DROP user_id');
    }
}
