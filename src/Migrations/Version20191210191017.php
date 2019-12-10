<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191210191017 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE refresh_tokens (id INT AUTO_INCREMENT NOT NULL, refresh_token VARCHAR(128) NOT NULL, username VARCHAR(255) NOT NULL, valid DATETIME NOT NULL, UNIQUE INDEX UNIQ_9BACE7E1C74F2195 (refresh_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE friend_request CHANGE user_id user_id INT DEFAULT NULL, CHANGE friend_id friend_id INT DEFAULT NULL, CHANGE accepted accepted TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE session CHANGE creator_id creator_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE meal CHANGE creator_id creator_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE refresh_tokens');
        $this->addSql('ALTER TABLE friend_request CHANGE user_id user_id INT DEFAULT NULL, CHANGE friend_id friend_id INT DEFAULT NULL, CHANGE accepted accepted TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE meal CHANGE creator_id creator_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE session CHANGE creator_id creator_id INT DEFAULT NULL');
    }
}
