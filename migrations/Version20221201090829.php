<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20221201090829 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add UserExperience';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE user_experience (user_id INT NOT NULL, coaster_id INT NOT NULL, is_done TINYINT(1) NOT NULL, INDEX IDX_A2F707EFA76ED395 (user_id), INDEX IDX_A2F707EF216303C (coaster_id), PRIMARY KEY(user_id, coaster_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_experience ADD CONSTRAINT FK_A2F707EFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_experience ADD CONSTRAINT FK_A2F707EF216303C FOREIGN KEY (coaster_id) REFERENCES coaster (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user_experience DROP FOREIGN KEY FK_A2F707EFA76ED395');
        $this->addSql('ALTER TABLE user_experience DROP FOREIGN KEY FK_A2F707EF216303C');
        $this->addSql('DROP TABLE user_experience');
    }
}
