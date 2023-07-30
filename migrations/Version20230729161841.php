<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230729161841 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE click ADD url_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE click ADD CONSTRAINT FK_BAF6C22081CFDAE7 FOREIGN KEY (url_id) REFERENCES url (id)');
        $this->addSql('CREATE INDEX IDX_BAF6C22081CFDAE7 ON click (url_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE click DROP FOREIGN KEY FK_BAF6C22081CFDAE7');
        $this->addSql('DROP INDEX IDX_BAF6C22081CFDAE7 ON click');
        $this->addSql('ALTER TABLE click DROP url_id');
    }
}
