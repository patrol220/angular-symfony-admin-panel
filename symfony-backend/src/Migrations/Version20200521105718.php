<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200521105718 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE users.users_settings (user_id VARCHAR(255) NOT NULL, notifications_subscriptions JSON NOT NULL, PRIMARY KEY(user_id))');
        $this->addSql('ALTER TABLE users.users ADD settings VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE users.users ADD CONSTRAINT FK_338ADFC4E545A0C5 FOREIGN KEY (settings) REFERENCES users.users_settings (user_id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_338ADFC4E545A0C5 ON users.users (settings)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE users.users DROP CONSTRAINT FK_338ADFC4E545A0C5');
        $this->addSql('DROP TABLE users.users_settings');
        $this->addSql('DROP INDEX UNIQ_338ADFC4E545A0C5');
        $this->addSql('ALTER TABLE users.users DROP settings');
    }
}
