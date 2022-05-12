<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220512083826 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, size INT NOT NULL, type VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE card ADD front_image_id INT DEFAULT NULL, ADD back_image_id INT DEFAULT NULL, DROP front_image, DROP back_image');
        $this->addSql('ALTER TABLE card ADD CONSTRAINT FK_161498D32DA66B91 FOREIGN KEY (front_image_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE card ADD CONSTRAINT FK_161498D3C77172ED FOREIGN KEY (back_image_id) REFERENCES media (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_161498D35E237E06 ON card (name)');
        $this->addSql('CREATE INDEX IDX_161498D32DA66B91 ON card (front_image_id)');
        $this->addSql('CREATE INDEX IDX_161498D3C77172ED ON card (back_image_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64C19C15E237E06 ON category (name)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE card DROP FOREIGN KEY FK_161498D32DA66B91');
        $this->addSql('ALTER TABLE card DROP FOREIGN KEY FK_161498D3C77172ED');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP INDEX UNIQ_161498D35E237E06 ON card');
        $this->addSql('DROP INDEX IDX_161498D32DA66B91 ON card');
        $this->addSql('DROP INDEX IDX_161498D3C77172ED ON card');
        $this->addSql('ALTER TABLE card ADD front_image VARCHAR(255) DEFAULT NULL, ADD back_image VARCHAR(255) DEFAULT NULL, DROP front_image_id, DROP back_image_id');
        $this->addSql('DROP INDEX UNIQ_64C19C15E237E06 ON category');
    }
}
