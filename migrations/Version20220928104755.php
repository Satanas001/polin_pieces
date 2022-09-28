<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220928104755 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creation of table quotation and relation with tables user and spare_part';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE quotation (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, creation_date DATETIME NOT NULL, comments LONGTEXT DEFAULT NULL, status SMALLINT NOT NULL, validation_date DATETIME DEFAULT NULL, INDEX IDX_474A8DB9A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quotation_part (part_id INT NOT NULL, quotation_id INT NOT NULL, quantity INT NOT NULL, unit_price NUMERIC(10, 2) DEFAULT NULL, INDEX IDX_D4FBD58A4CE34BEC (part_id), INDEX IDX_D4FBD58AB4EA4E60 (quotation_id), PRIMARY KEY(part_id, quotation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE quotation ADD CONSTRAINT FK_474A8DB9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE quotation_part ADD CONSTRAINT FK_D4FBD58A4CE34BEC FOREIGN KEY (part_id) REFERENCES spare_part (id)');
        $this->addSql('ALTER TABLE quotation_part ADD CONSTRAINT FK_D4FBD58AB4EA4E60 FOREIGN KEY (quotation_id) REFERENCES quotation (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE quotation DROP FOREIGN KEY FK_474A8DB9A76ED395');
        $this->addSql('ALTER TABLE quotation_part DROP FOREIGN KEY FK_D4FBD58A4CE34BEC');
        $this->addSql('ALTER TABLE quotation_part DROP FOREIGN KEY FK_D4FBD58AB4EA4E60');
        $this->addSql('DROP TABLE quotation');
        $this->addSql('DROP TABLE quotation_part');
    }
}
