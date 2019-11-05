<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191029202618 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE reservations ADD apartment_id INT NOT NULL');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239176DFE85 FOREIGN KEY (apartment_id) REFERENCES apartments (id)');
        $this->addSql('CREATE INDEX IDX_4DA239176DFE85 ON reservations (apartment_id)');
        $this->addSql('ALTER TABLE apartments DROP FOREIGN KEY FK_7745248EB83297E7');
        $this->addSql('DROP INDEX IDX_7745248EB83297E7 ON apartments');
        $this->addSql('ALTER TABLE apartments DROP reservation_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE apartments ADD reservation_id INT NOT NULL');
        $this->addSql('ALTER TABLE apartments ADD CONSTRAINT FK_7745248EB83297E7 FOREIGN KEY (reservation_id) REFERENCES reservations (id)');
        $this->addSql('CREATE INDEX IDX_7745248EB83297E7 ON apartments (reservation_id)');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA239176DFE85');
        $this->addSql('DROP INDEX IDX_4DA239176DFE85 ON reservations');
        $this->addSql('ALTER TABLE reservations DROP apartment_id');
    }
}
