<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20221018134651 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add relations';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE coaster_tag (coaster_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_4730B5A7216303C (coaster_id), INDEX IDX_4730B5A7BAD26311 (tag_id), PRIMARY KEY(coaster_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE coaster_tag ADD CONSTRAINT FK_4730B5A7216303C FOREIGN KEY (coaster_id) REFERENCES coaster (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE coaster_tag ADD CONSTRAINT FK_4730B5A7BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE coaster ADD manufacturer_id INT NOT NULL, ADD park_id INT NOT NULL');
        $this->addSql('ALTER TABLE coaster ADD CONSTRAINT FK_F6312A78A23B42D FOREIGN KEY (manufacturer_id) REFERENCES manufacturer (id)');
        $this->addSql('ALTER TABLE coaster ADD CONSTRAINT FK_F6312A7844990C25 FOREIGN KEY (park_id) REFERENCES park (id)');
        $this->addSql('CREATE INDEX IDX_F6312A78A23B42D ON coaster (manufacturer_id)');
        $this->addSql('CREATE INDEX IDX_F6312A7844990C25 ON coaster (park_id)');
        $this->addSql('ALTER TABLE park ADD address_id INT NOT NULL');
        $this->addSql('ALTER TABLE park ADD CONSTRAINT FK_C4077D33F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C4077D33F5B7AF75 ON park (address_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE coaster_tag DROP FOREIGN KEY FK_4730B5A7216303C');
        $this->addSql('ALTER TABLE coaster_tag DROP FOREIGN KEY FK_4730B5A7BAD26311');
        $this->addSql('DROP TABLE coaster_tag');
        $this->addSql('ALTER TABLE coaster DROP FOREIGN KEY FK_F6312A78A23B42D');
        $this->addSql('ALTER TABLE coaster DROP FOREIGN KEY FK_F6312A7844990C25');
        $this->addSql('DROP INDEX IDX_F6312A78A23B42D ON coaster');
        $this->addSql('DROP INDEX IDX_F6312A7844990C25 ON coaster');
        $this->addSql('ALTER TABLE coaster DROP manufacturer_id, DROP park_id');
        $this->addSql('ALTER TABLE park DROP FOREIGN KEY FK_C4077D33F5B7AF75');
        $this->addSql('DROP INDEX UNIQ_C4077D33F5B7AF75 ON park');
        $this->addSql('ALTER TABLE park DROP address_id');
    }
}
