<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200331074555 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article ADD user_id INT DEFAULT NULL, CHANGE titre titre VARCHAR(255) NOT NULL, CHANGE slug slug VARCHAR(255) NOT NULL, CHANGE contenu contenu LONGTEXT NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL, CHANGE featured_image featured_image VARCHAR(255) NOT NULL, CHANGE email email VARCHAR(255) NOT NULL, CHANGE pseudo pseudo VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_23A0E66A76ED395 ON article (user_id)');
        $this->addSql('ALTER TABLE commentaire CHANGE updated_at updated_at DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66A76ED395');
        $this->addSql('DROP INDEX IDX_23A0E66A76ED395 ON article');
        $this->addSql('ALTER TABLE article DROP user_id, CHANGE titre titre VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE slug slug VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE contenu contenu LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL, CHANGE featured_image featured_image VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE pseudo pseudo VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE commentaire CHANGE updated_at updated_at DATETIME DEFAULT NULL');
    }
}
