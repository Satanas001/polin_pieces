<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220928095230 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creation of table spare_part';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE spare_part (id INT AUTO_INCREMENT NOT NULL, reference VARCHAR(25) NOT NULL, designation VARCHAR(100) NOT NULL, unit_price NUMERIC(10, 2) DEFAULT NULL, image VARCHAR(50) DEFAULT NULL, description LONGTEXT DEFAULT NULL, is_enabled TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE spare_part');
    }
}
