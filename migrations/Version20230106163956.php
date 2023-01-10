<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230106163956 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE movies_actor (movies_id INT NOT NULL, actor_id INT NOT NULL, INDEX IDX_3F9774F853F590A4 (movies_id), INDEX IDX_3F9774F810DAF24A (actor_id), PRIMARY KEY(movies_id, actor_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE movies_actor ADD CONSTRAINT FK_3F9774F853F590A4 FOREIGN KEY (movies_id) REFERENCES movies (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE movies_actor ADD CONSTRAINT FK_3F9774F810DAF24A FOREIGN KEY (actor_id) REFERENCES actor (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movies_actor DROP FOREIGN KEY FK_3F9774F853F590A4');
        $this->addSql('ALTER TABLE movies_actor DROP FOREIGN KEY FK_3F9774F810DAF24A');
        $this->addSql('DROP TABLE movies_actor');
    }
}
