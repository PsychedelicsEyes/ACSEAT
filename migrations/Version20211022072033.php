<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211022072033 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD3DA5256D');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP INDEX UNIQ_D34A04AD3DA5256D ON product');
        $this->addSql('ALTER TABLE product ADD file_name VARCHAR(255) NOT NULL, DROP image_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE product ADD image_id INT DEFAULT NULL, DROP file_name');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD3DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D34A04AD3DA5256D ON product (image_id)');
    }
}
