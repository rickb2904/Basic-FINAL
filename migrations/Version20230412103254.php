<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230412103254 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activite ADD seancelibre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE activite ADD seancecollective_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE activite ADD CONSTRAINT FK_B87555153A4DAFA FOREIGN KEY (seancelibre_id) REFERENCES seance_libre (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE activite ADD CONSTRAINT FK_B875551550D00C75 FOREIGN KEY (seancecollective_id) REFERENCES seance_collective (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B87555153A4DAFA ON activite (seancelibre_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B875551550D00C75 ON activite (seancecollective_id)');
        $this->addSql('ALTER TABLE adherent ADD coach_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE adherent ADD CONSTRAINT FK_90D3F0603C105691 FOREIGN KEY (coach_id) REFERENCES coach (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_90D3F0603C105691 ON adherent (coach_id)');
        $this->addSql('ALTER TABLE fiche_sante ADD adherent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fiche_sante ADD CONSTRAINT FK_B588D85425F06C53 FOREIGN KEY (adherent_id) REFERENCES adherent (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_B588D85425F06C53 ON fiche_sante (adherent_id)');
        $this->addSql('ALTER TABLE seance_collective ADD adherent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE seance_collective ADD coach_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE seance_collective ADD CONSTRAINT FK_FAC189C725F06C53 FOREIGN KEY (adherent_id) REFERENCES adherent (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE seance_collective ADD CONSTRAINT FK_FAC189C73C105691 FOREIGN KEY (coach_id) REFERENCES coach (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_FAC189C725F06C53 ON seance_collective (adherent_id)');
        $this->addSql('CREATE INDEX IDX_FAC189C73C105691 ON seance_collective (coach_id)');
        $this->addSql('ALTER TABLE seance_libre ADD adherent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE seance_libre ADD CONSTRAINT FK_A85A577925F06C53 FOREIGN KEY (adherent_id) REFERENCES adherent (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_A85A577925F06C53 ON seance_libre (adherent_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE activite DROP CONSTRAINT FK_B87555153A4DAFA');
        $this->addSql('ALTER TABLE activite DROP CONSTRAINT FK_B875551550D00C75');
        $this->addSql('DROP INDEX UNIQ_B87555153A4DAFA');
        $this->addSql('DROP INDEX UNIQ_B875551550D00C75');
        $this->addSql('ALTER TABLE activite DROP seancelibre_id');
        $this->addSql('ALTER TABLE activite DROP seancecollective_id');
        $this->addSql('ALTER TABLE adherent DROP CONSTRAINT FK_90D3F0603C105691');
        $this->addSql('DROP INDEX IDX_90D3F0603C105691');
        $this->addSql('ALTER TABLE adherent DROP coach_id');
        $this->addSql('ALTER TABLE fiche_sante DROP CONSTRAINT FK_B588D85425F06C53');
        $this->addSql('DROP INDEX IDX_B588D85425F06C53');
        $this->addSql('ALTER TABLE fiche_sante DROP adherent_id');
        $this->addSql('ALTER TABLE seance_collective DROP CONSTRAINT FK_FAC189C725F06C53');
        $this->addSql('ALTER TABLE seance_collective DROP CONSTRAINT FK_FAC189C73C105691');
        $this->addSql('DROP INDEX IDX_FAC189C725F06C53');
        $this->addSql('DROP INDEX IDX_FAC189C73C105691');
        $this->addSql('ALTER TABLE seance_collective DROP adherent_id');
        $this->addSql('ALTER TABLE seance_collective DROP coach_id');
        $this->addSql('ALTER TABLE seance_libre DROP CONSTRAINT FK_A85A577925F06C53');
        $this->addSql('DROP INDEX IDX_A85A577925F06C53');
        $this->addSql('ALTER TABLE seance_libre DROP adherent_id');
    }
}
