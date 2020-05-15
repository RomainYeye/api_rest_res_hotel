<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200427151105 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE categorie CHANGE lit_simple lit_simple INT DEFAULT NULL, CHANGE lit_double lit_double INT DEFAULT NULL, CHANGE lit_king lit_king INT DEFAULT NULL');
        $this->addSql('ALTER TABLE chambre ADD hotel_id INT NOT NULL, ADD categorie_id INT NOT NULL');
        $this->addSql('ALTER TABLE chambre ADD CONSTRAINT FK_C509E4FF3243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id)');
        $this->addSql('ALTER TABLE chambre ADD CONSTRAINT FK_C509E4FFBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_C509E4FF3243BB18 ON chambre (hotel_id)');
        $this->addSql('CREATE INDEX IDX_C509E4FFBCF5E72D ON chambre (categorie_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE categorie CHANGE lit_simple lit_simple INT DEFAULT NULL, CHANGE lit_double lit_double INT DEFAULT NULL, CHANGE lit_king lit_king INT DEFAULT NULL');
        $this->addSql('ALTER TABLE chambre DROP FOREIGN KEY FK_C509E4FF3243BB18');
        $this->addSql('ALTER TABLE chambre DROP FOREIGN KEY FK_C509E4FFBCF5E72D');
        $this->addSql('DROP INDEX IDX_C509E4FF3243BB18 ON chambre');
        $this->addSql('DROP INDEX IDX_C509E4FFBCF5E72D ON chambre');
        $this->addSql('ALTER TABLE chambre DROP hotel_id, DROP categorie_id');
    }
}
