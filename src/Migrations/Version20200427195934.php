<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200427195934 extends AbstractMigration
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
        $this->addSql('ALTER TABLE tarification MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE tarification DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE tarification ADD hotel_id INT NOT NULL, ADD categorie_id INT NOT NULL, DROP id');
        $this->addSql('ALTER TABLE tarification ADD CONSTRAINT FK_61328163243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id)');
        $this->addSql('ALTER TABLE tarification ADD CONSTRAINT FK_6132816BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_61328163243BB18 ON tarification (hotel_id)');
        $this->addSql('CREATE INDEX IDX_6132816BCF5E72D ON tarification (categorie_id)');
        $this->addSql('ALTER TABLE tarification ADD PRIMARY KEY (hotel_id, categorie_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE categorie CHANGE lit_simple lit_simple INT DEFAULT NULL, CHANGE lit_double lit_double INT DEFAULT NULL, CHANGE lit_king lit_king INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tarification DROP FOREIGN KEY FK_61328163243BB18');
        $this->addSql('ALTER TABLE tarification DROP FOREIGN KEY FK_6132816BCF5E72D');
        $this->addSql('DROP INDEX IDX_61328163243BB18 ON tarification');
        $this->addSql('DROP INDEX IDX_6132816BCF5E72D ON tarification');
        $this->addSql('ALTER TABLE tarification ADD id INT AUTO_INCREMENT NOT NULL, DROP hotel_id, DROP categorie_id, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
    }
}
