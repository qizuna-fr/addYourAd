<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230913153618 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ad_collection (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ad ADD ad_collection_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ad ADD CONSTRAINT FK_77E0ED589C7218D7 FOREIGN KEY (ad_collection_id) REFERENCES ad_collection (id)');
        $this->addSql('CREATE INDEX IDX_77E0ED589C7218D7 ON ad (ad_collection_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ad DROP FOREIGN KEY FK_77E0ED589C7218D7');
        $this->addSql('DROP TABLE ad_collection');
        $this->addSql('DROP INDEX IDX_77E0ED589C7218D7 ON ad');
        $this->addSql('ALTER TABLE ad DROP ad_collection_id');
    }
}
