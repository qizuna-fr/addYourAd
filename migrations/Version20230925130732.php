<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230925130732 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ad (id INT AUTO_INCREMENT NOT NULL, started_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', ended_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', weight INT NOT NULL, views INT NOT NULL, image VARCHAR(255) DEFAULT NULL, image_size INT DEFAULT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', link VARCHAR(255) DEFAULT NULL, total_views INT NOT NULL, image_base64 LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ad_collection (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ad_collection_ad (ad_collection_id INT NOT NULL, ad_id INT NOT NULL, INDEX IDX_54AB92DF9C7218D7 (ad_collection_id), INDEX IDX_54AB92DF4F34D596 (ad_id), PRIMARY KEY(ad_collection_id, ad_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ad_collection_ad ADD CONSTRAINT FK_54AB92DF9C7218D7 FOREIGN KEY (ad_collection_id) REFERENCES ad_collection (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ad_collection_ad ADD CONSTRAINT FK_54AB92DF4F34D596 FOREIGN KEY (ad_id) REFERENCES ad (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ad_collection_ad DROP FOREIGN KEY FK_54AB92DF9C7218D7');
        $this->addSql('ALTER TABLE ad_collection_ad DROP FOREIGN KEY FK_54AB92DF4F34D596');
        $this->addSql('DROP TABLE ad');
        $this->addSql('DROP TABLE ad_collection');
        $this->addSql('DROP TABLE ad_collection_ad');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
