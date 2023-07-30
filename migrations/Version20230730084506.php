<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230730084506 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE click DROP FOREIGN KEY FK_BAF6C22081CFDAE7');
        $this->addSql('ALTER TABLE click CHANGE url_id url_id INT NOT NULL');
        $this->addSql('ALTER TABLE click ADD CONSTRAINT FK_BAF6C22081CFDAE7 FOREIGN KEY (url_id) REFERENCES url (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE click DROP FOREIGN KEY FK_BAF6C22081CFDAE7');
        $this->addSql('ALTER TABLE click CHANGE url_id url_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE click ADD CONSTRAINT FK_BAF6C22081CFDAE7 FOREIGN KEY (url_id) REFERENCES url (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
