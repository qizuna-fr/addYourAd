<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230914135950 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ad_collection_ad (ad_collection_id INT NOT NULL, ad_id INT NOT NULL, INDEX IDX_54AB92DF9C7218D7 (ad_collection_id), INDEX IDX_54AB92DF4F34D596 (ad_id), PRIMARY KEY(ad_collection_id, ad_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ad_collection_ad ADD CONSTRAINT FK_54AB92DF9C7218D7 FOREIGN KEY (ad_collection_id) REFERENCES ad_collection (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ad_collection_ad ADD CONSTRAINT FK_54AB92DF4F34D596 FOREIGN KEY (ad_id) REFERENCES ad (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ad DROP FOREIGN KEY FK_77E0ED589C7218D7');
        $this->addSql('DROP INDEX IDX_77E0ED589C7218D7 ON ad');
        $this->addSql('ALTER TABLE ad ADD total_views INT NOT NULL, DROP ad_collection_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ad_collection_ad DROP FOREIGN KEY FK_54AB92DF9C7218D7');
        $this->addSql('ALTER TABLE ad_collection_ad DROP FOREIGN KEY FK_54AB92DF4F34D596');
        $this->addSql('DROP TABLE ad_collection_ad');
        $this->addSql('ALTER TABLE ad ADD ad_collection_id INT DEFAULT NULL, DROP total_views');
        $this->addSql('ALTER TABLE ad ADD CONSTRAINT FK_77E0ED589C7218D7 FOREIGN KEY (ad_collection_id) REFERENCES ad_collection (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_77E0ED589C7218D7 ON ad (ad_collection_id)');
    }
}
