<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200506110023 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE products.category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE products.category (id INT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F495DEE4727ACA70 ON products.category (parent_id)');
        $this->addSql('ALTER TABLE products.category ADD CONSTRAINT FK_F495DEE4727ACA70 FOREIGN KEY (parent_id) REFERENCES products.category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE products.products ADD category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE products.products ADD CONSTRAINT FK_41639D7F12469DE2 FOREIGN KEY (category_id) REFERENCES products.category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_41639D7F12469DE2 ON products.products (category_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE products.products DROP CONSTRAINT FK_41639D7F12469DE2');
        $this->addSql('ALTER TABLE products.category DROP CONSTRAINT FK_F495DEE4727ACA70');
        $this->addSql('DROP SEQUENCE products.category_id_seq CASCADE');
        $this->addSql('DROP TABLE products.category');
        $this->addSql('DROP INDEX products.IDX_41639D7F12469DE2');
        $this->addSql('ALTER TABLE products.products DROP category_id');
    }
}
