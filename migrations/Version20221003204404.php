<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20221003204404 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add « active » field on certain tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE category ADD active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE company ADD active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE device_model ADD active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE device_type ADD active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE document_category ADD active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE status status TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE category DROP active');
        $this->addSql('ALTER TABLE company DROP active');
        $this->addSql('ALTER TABLE device_model DROP active');
        $this->addSql('ALTER TABLE device_type DROP active');
        $this->addSql('ALTER TABLE document_category DROP active');
        $this->addSql('ALTER TABLE user CHANGE status status SMALLINT NOT NULL');
    }
}
