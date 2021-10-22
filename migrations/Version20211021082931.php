<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211021082931 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` ADD amount_total DOUBLE PRECISION NOT NULL, ADD quantite_product INT NOT NULL, DROP total_amount, DROP product_amount, CHANGE number_product product_id INT NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993984584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_F52993984584665A ON `order` (product_id)');
        $this->addSql('ALTER TABLE user ADD order_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64951147ADE FOREIGN KEY (order_user_id) REFERENCES `order` (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64951147ADE ON user (order_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993984584665A');
        $this->addSql('DROP INDEX IDX_F52993984584665A ON `order`');
        $this->addSql('ALTER TABLE `order` ADD number_product INT NOT NULL, ADD product_amount DOUBLE PRECISION NOT NULL, DROP product_id, DROP quantite_product, CHANGE amount_total total_amount DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D64951147ADE');
        $this->addSql('DROP INDEX IDX_8D93D64951147ADE ON `user`');
        $this->addSql('ALTER TABLE `user` DROP order_user_id');
    }
}
