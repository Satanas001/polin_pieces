<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220928095735 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creation of relation between tables spare_part and device_model';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE spare_part_device_model (spare_part_id INT NOT NULL, device_model_id INT NOT NULL, INDEX IDX_CD2D1FDE49B7A72 (spare_part_id), INDEX IDX_CD2D1FDEF741EEC7 (device_model_id), PRIMARY KEY(spare_part_id, device_model_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE spare_part_device_model ADD CONSTRAINT FK_CD2D1FDE49B7A72 FOREIGN KEY (spare_part_id) REFERENCES spare_part (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE spare_part_device_model ADD CONSTRAINT FK_CD2D1FDEF741EEC7 FOREIGN KEY (device_model_id) REFERENCES device_model (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE spare_part_device_model DROP FOREIGN KEY FK_CD2D1FDE49B7A72');
        $this->addSql('ALTER TABLE spare_part_device_model DROP FOREIGN KEY FK_CD2D1FDEF741EEC7');
        $this->addSql('DROP TABLE spare_part_device_model');
    }
}
