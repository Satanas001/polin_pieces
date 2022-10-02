<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20221002143925 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Renaming additional_adress to additional_address';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE company CHANGE additional_adress additional_address VARCHAR(100) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE company CHANGE additional_address additional_adress VARCHAR(100) DEFAULT NULL');
    }
}
