<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220928085729 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creation of table category, device_model, device_type and device_model_document';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE device_model (id INT AUTO_INCREMENT NOT NULL, device_type_id INT NOT NULL, designation VARCHAR(50) NOT NULL, INDEX IDX_111092BE4FFA550E (device_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE device_model_document (device_model_id INT NOT NULL, document_id INT NOT NULL, INDEX IDX_B4FE2A65F741EEC7 (device_model_id), INDEX IDX_B4FE2A65C33F7837 (document_id), PRIMARY KEY(device_model_id, document_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE device_type (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, designation VARCHAR(50) NOT NULL, INDEX IDX_5E7821312469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE device_model ADD CONSTRAINT FK_111092BE4FFA550E FOREIGN KEY (device_type_id) REFERENCES device_type (id)');
        $this->addSql('ALTER TABLE device_model_document ADD CONSTRAINT FK_B4FE2A65F741EEC7 FOREIGN KEY (device_model_id) REFERENCES device_model (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE device_model_document ADD CONSTRAINT FK_B4FE2A65C33F7837 FOREIGN KEY (document_id) REFERENCES document (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE device_type ADD CONSTRAINT FK_5E7821312469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE device_model DROP FOREIGN KEY FK_111092BE4FFA550E');
        $this->addSql('ALTER TABLE device_model_document DROP FOREIGN KEY FK_B4FE2A65F741EEC7');
        $this->addSql('ALTER TABLE device_model_document DROP FOREIGN KEY FK_B4FE2A65C33F7837');
        $this->addSql('ALTER TABLE device_type DROP FOREIGN KEY FK_5E7821312469DE2');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE device_model');
        $this->addSql('DROP TABLE device_model_document');
        $this->addSql('DROP TABLE device_type');
    }
}
