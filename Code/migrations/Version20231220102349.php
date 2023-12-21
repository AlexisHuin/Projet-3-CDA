<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231220102349 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cadeau (id INT AUTO_INCREMENT NOT NULL, nom_partenaire VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, site_web_partenaire VARCHAR(255) NOT NULL, date_expiration DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cadeau_user (cadeau_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_65AADA80D9D5ED84 (cadeau_id), INDEX IDX_65AADA80A76ED395 (user_id), PRIMARY KEY(cadeau_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaires_itineraire (id INT AUTO_INCREMENT NOT NULL, itineraire_id INT NOT NULL, membre_id INT NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, note INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_DB0C4D02A9B853B8 (itineraire_id), INDEX IDX_DB0C4D026A99F74A (membre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaires_lieu (id INT AUTO_INCREMENT NOT NULL, membre_id INT NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, note INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', lieu_gps VARCHAR(255) NOT NULL, INDEX IDX_879000136A99F74A (membre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE itineraire (id INT AUTO_INCREMENT NOT NULL, membre_id INT NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, lieux LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_487C9A116A99F74A (membre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE itineraire_categorie (itineraire_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_1F2DEA9EA9B853B8 (itineraire_id), INDEX IDX_1F2DEA9EBCF5E72D (categorie_id), PRIMARY KEY(itineraire_id, categorie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, avatar_url VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', favorite_places LONGTEXT DEFAULT NULL, gift_points INT NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cadeau_user ADD CONSTRAINT FK_65AADA80D9D5ED84 FOREIGN KEY (cadeau_id) REFERENCES cadeau (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cadeau_user ADD CONSTRAINT FK_65AADA80A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaires_itineraire ADD CONSTRAINT FK_DB0C4D02A9B853B8 FOREIGN KEY (itineraire_id) REFERENCES itineraire (id)');
        $this->addSql('ALTER TABLE commentaires_itineraire ADD CONSTRAINT FK_DB0C4D026A99F74A FOREIGN KEY (membre_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commentaires_lieu ADD CONSTRAINT FK_879000136A99F74A FOREIGN KEY (membre_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE itineraire ADD CONSTRAINT FK_487C9A116A99F74A FOREIGN KEY (membre_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE itineraire_categorie ADD CONSTRAINT FK_1F2DEA9EA9B853B8 FOREIGN KEY (itineraire_id) REFERENCES itineraire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE itineraire_categorie ADD CONSTRAINT FK_1F2DEA9EBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cadeau_user DROP FOREIGN KEY FK_65AADA80D9D5ED84');
        $this->addSql('ALTER TABLE cadeau_user DROP FOREIGN KEY FK_65AADA80A76ED395');
        $this->addSql('ALTER TABLE commentaires_itineraire DROP FOREIGN KEY FK_DB0C4D02A9B853B8');
        $this->addSql('ALTER TABLE commentaires_itineraire DROP FOREIGN KEY FK_DB0C4D026A99F74A');
        $this->addSql('ALTER TABLE commentaires_lieu DROP FOREIGN KEY FK_879000136A99F74A');
        $this->addSql('ALTER TABLE itineraire DROP FOREIGN KEY FK_487C9A116A99F74A');
        $this->addSql('ALTER TABLE itineraire_categorie DROP FOREIGN KEY FK_1F2DEA9EA9B853B8');
        $this->addSql('ALTER TABLE itineraire_categorie DROP FOREIGN KEY FK_1F2DEA9EBCF5E72D');
        $this->addSql('DROP TABLE cadeau');
        $this->addSql('DROP TABLE cadeau_user');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE commentaires_itineraire');
        $this->addSql('DROP TABLE commentaires_lieu');
        $this->addSql('DROP TABLE itineraire');
        $this->addSql('DROP TABLE itineraire_categorie');
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
