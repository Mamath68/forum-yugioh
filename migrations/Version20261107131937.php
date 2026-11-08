<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261107131937 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category ADD publication_date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE posts ADD topic_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE posts ADD CONSTRAINT FK_885DBAFA1F55203D FOREIGN KEY (topic_id) REFERENCES topic (id)');
        $this->addSql('CREATE INDEX IDX_885DBAFA1F55203D ON posts (topic_id)');
        $this->addSql('ALTER TABLE topic ADD category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE topic ADD CONSTRAINT FK_9D40DE1B12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_9D40DE1B12469DE2 ON topic (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category DROP publication_date');
        $this->addSql('ALTER TABLE posts DROP FOREIGN KEY FK_885DBAFA1F55203D');
        $this->addSql('DROP INDEX IDX_885DBAFA1F55203D ON posts');
        $this->addSql('ALTER TABLE posts DROP topic_id');
        $this->addSql('ALTER TABLE topic DROP FOREIGN KEY FK_9D40DE1B12469DE2');
        $this->addSql('DROP INDEX IDX_9D40DE1B12469DE2 ON topic');
        $this->addSql('ALTER TABLE topic DROP category_id');
    }
}
