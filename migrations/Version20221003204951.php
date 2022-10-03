<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20221003204951 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add field Reference onto the Quotation entity.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE quotation ADD reference VARCHAR(50) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE quotation DROP reference');
    }
}
