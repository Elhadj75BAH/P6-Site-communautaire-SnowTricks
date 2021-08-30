<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210830222504 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C4FB88E14F');
        $this->addSql('ALTER TABLE figure DROP FOREIGN KEY FK_2F57B37AFB88E14F');
        $this->addSql('CREATE TABLE utilisateurs (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, picture VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_497B315EE7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP INDEX IDX_D9BEC0C4FB88E14F ON commentaires');
        $this->addSql('ALTER TABLE commentaires CHANGE utilisateur_id utilisateurs_id INT NOT NULL');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C41E969C5 FOREIGN KEY (utilisateurs_id) REFERENCES utilisateurs (id)');
        $this->addSql('CREATE INDEX IDX_D9BEC0C41E969C5 ON commentaires (utilisateurs_id)');
        $this->addSql('DROP INDEX IDX_2F57B37AFB88E14F ON figure');
        $this->addSql('ALTER TABLE figure CHANGE utilisateur_id utilisateurs_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE figure ADD CONSTRAINT FK_2F57B37A1E969C5 FOREIGN KEY (utilisateurs_id) REFERENCES utilisateurs (id)');
        $this->addSql('CREATE INDEX IDX_2F57B37A1E969C5 ON figure (utilisateurs_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C41E969C5');
        $this->addSql('ALTER TABLE figure DROP FOREIGN KEY FK_2F57B37A1E969C5');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(70) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(70) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, mot_de_passe VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, picture VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE utilisateurs');
        $this->addSql('DROP INDEX IDX_D9BEC0C41E969C5 ON commentaires');
        $this->addSql('ALTER TABLE commentaires CHANGE utilisateurs_id utilisateur_id INT NOT NULL');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C4FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_D9BEC0C4FB88E14F ON commentaires (utilisateur_id)');
        $this->addSql('DROP INDEX IDX_2F57B37A1E969C5 ON figure');
        $this->addSql('ALTER TABLE figure CHANGE utilisateurs_id utilisateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE figure ADD CONSTRAINT FK_2F57B37AFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_2F57B37AFB88E14F ON figure (utilisateur_id)');
    }
}
