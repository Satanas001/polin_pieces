<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220928080554 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creation of tables document & document_category';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE document (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, filename VARCHAR(50) NOT NULL, INDEX IDX_D8698A7612469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document_category (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A7612469DE2 FOREIGN KEY (category_id) REFERENCES document_category (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A7612469DE2');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE document_category');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
