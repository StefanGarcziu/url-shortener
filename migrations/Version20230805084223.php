<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230805084223 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE anonymous_users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clicks (id INT AUTO_INCREMENT NOT NULL, url_id INT NOT NULL, date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ip VARCHAR(255) NOT NULL, INDEX IDX_20DA190181CFDAE7 (url_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tags (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(45) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE urls (id INT AUTO_INCREMENT NOT NULL, anonymous_user_id INT DEFAULT NULL, long_url VARCHAR(255) NOT NULL, creation_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', mod_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_2A9437A152656F32 (anonymous_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE urls_tags (url_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_87534E0781CFDAE7 (url_id), INDEX IDX_87534E07BAD26311 (tag_id), PRIMARY KEY(url_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE clicks ADD CONSTRAINT FK_20DA190181CFDAE7 FOREIGN KEY (url_id) REFERENCES urls (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE urls ADD CONSTRAINT FK_2A9437A152656F32 FOREIGN KEY (anonymous_user_id) REFERENCES anonymous_users (id)');
        $this->addSql('ALTER TABLE urls_tags ADD CONSTRAINT FK_87534E0781CFDAE7 FOREIGN KEY (url_id) REFERENCES urls (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE urls_tags ADD CONSTRAINT FK_87534E07BAD26311 FOREIGN KEY (tag_id) REFERENCES tags (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE url');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE url (id INT AUTO_INCREMENT NOT NULL, short_url VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, long_url VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, creation_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', mod_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE clicks DROP FOREIGN KEY FK_20DA190181CFDAE7');
        $this->addSql('ALTER TABLE urls DROP FOREIGN KEY FK_2A9437A152656F32');
        $this->addSql('ALTER TABLE urls_tags DROP FOREIGN KEY FK_87534E0781CFDAE7');
        $this->addSql('ALTER TABLE urls_tags DROP FOREIGN KEY FK_87534E07BAD26311');
        $this->addSql('DROP TABLE anonymous_users');
        $this->addSql('DROP TABLE clicks');
        $this->addSql('DROP TABLE tags');
        $this->addSql('DROP TABLE urls');
        $this->addSql('DROP TABLE urls_tags');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
