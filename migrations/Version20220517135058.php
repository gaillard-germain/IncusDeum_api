<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220517135058 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE card (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, front_image_id INT DEFAULT NULL, back_image_id INT DEFAULT NULL, name VARCHAR(60) NOT NULL, value INT NOT NULL, description LONGTEXT NOT NULL, color VARCHAR(60) DEFAULT NULL, UNIQUE INDEX UNIQ_161498D35E237E06 (name), INDEX IDX_161498D312469DE2 (category_id), INDEX IDX_161498D32DA66B91 (front_image_id), INDEX IDX_161498D3C77172ED (back_image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE card_fx (card_id INT NOT NULL, fx_id INT NOT NULL, INDEX IDX_D955DAA04ACC9A20 (card_id), INDEX IDX_D955DAA0E7DBE1A1 (fx_id), PRIMARY KEY(card_id, fx_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(60) NOT NULL, UNIQUE INDEX UNIQ_64C19C15E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fx (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, value VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, size INT NOT NULL, type VARCHAR(100) NOT NULL, url VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE card ADD CONSTRAINT FK_161498D312469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE card ADD CONSTRAINT FK_161498D32DA66B91 FOREIGN KEY (front_image_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE card ADD CONSTRAINT FK_161498D3C77172ED FOREIGN KEY (back_image_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE card_fx ADD CONSTRAINT FK_D955DAA04ACC9A20 FOREIGN KEY (card_id) REFERENCES card (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE card_fx ADD CONSTRAINT FK_D955DAA0E7DBE1A1 FOREIGN KEY (fx_id) REFERENCES fx (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE card_fx DROP FOREIGN KEY FK_D955DAA04ACC9A20');
        $this->addSql('ALTER TABLE card DROP FOREIGN KEY FK_161498D312469DE2');
        $this->addSql('ALTER TABLE card_fx DROP FOREIGN KEY FK_D955DAA0E7DBE1A1');
        $this->addSql('ALTER TABLE card DROP FOREIGN KEY FK_161498D32DA66B91');
        $this->addSql('ALTER TABLE card DROP FOREIGN KEY FK_161498D3C77172ED');
        $this->addSql('DROP TABLE card');
        $this->addSql('DROP TABLE card_fx');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE fx');
        $this->addSql('DROP TABLE media');
    }
}
