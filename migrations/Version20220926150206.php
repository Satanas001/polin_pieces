<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220926150206 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creation of Document and Document Category tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE document_category (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE filename (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, filename VARCHAR(50) NOT NULL, INDEX IDX_3C0BE96512469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE filename ADD CONSTRAINT FK_3C0BE96512469DE2 FOREIGN KEY (category_id) REFERENCES document_category (id)');
        $this->addSql('ALTER TABLE user ADD company_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649979B1AD6 ON user (company_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE filename DROP FOREIGN KEY FK_3C0BE96512469DE2');
        $this->addSql('DROP TABLE document_category');
        $this->addSql('DROP TABLE filename');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649979B1AD6');
        $this->addSql('DROP INDEX IDX_8D93D649979B1AD6 ON user');
        $this->addSql('ALTER TABLE user DROP company_id');
    }
}
