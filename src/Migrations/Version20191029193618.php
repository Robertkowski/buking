<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191029193618 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE apartament DROP FOREIGN KEY FK_551D61F9B83297E7');
        $this->addSql('CREATE TABLE reservations (id INT AUTO_INCREMENT NOT NULL, booking_from DATETIME NOT NULL, booking_to DATETIME NOT NULL, taken_slots INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE apartments (id INT AUTO_INCREMENT NOT NULL, reservation_id INT NOT NULL, slots INT NOT NULL, discount_over_seven_days INT NOT NULL, INDEX IDX_7745248EB83297E7 (reservation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE apartments ADD CONSTRAINT FK_7745248EB83297E7 FOREIGN KEY (reservation_id) REFERENCES reservations (id)');
        $this->addSql('DROP TABLE apartament');
        $this->addSql('DROP TABLE reservation');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE apartments DROP FOREIGN KEY FK_7745248EB83297E7');
        $this->addSql('CREATE TABLE apartament (id INT AUTO_INCREMENT NOT NULL, reservation_id INT NOT NULL, slots INT NOT NULL, discount_over_seven_days INT NOT NULL, INDEX IDX_551D61F9B83297E7 (reservation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, booking_from DATETIME NOT NULL, booking_to DATETIME NOT NULL, taken_slots INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE apartament ADD CONSTRAINT FK_551D61F9B83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id)');
        $this->addSql('DROP TABLE reservations');
        $this->addSql('DROP TABLE apartments');
    }
}
